<?php

namespace App\Http\Controllers\Frontend\Orders;


use App\Http\Controllers\Frontend\FrontendBaseController;
use App\Mail\NewOrderMail;
use App\Models\Carts\Carts;
use App\Models\Catalog\Product;
use App\Models\Orders\OrderProducts;
use App\Models\Orders\Orders;
use App\Models\Users\Address;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cookie;

class OrdersController extends FrontendBaseController
{

    public function sendPaymentRequest(Request $request)
    {
         /** Génère le numéro de transaction **/
        $payment_id = generateUniqueAn6();
        $payment_data = config('payment.vads_fields');
        $payment_data['vads_trans_id'] = $payment_id;

        /** Informations sur le panier **/
        $cart = Carts::findOrFail($request->cart);
        $payment_data['vads_nb_products'] = $cart->countProduct();
        $payment_data['vads_amount'] = $cart->total_ttc;
        $payment_data['vads_pretax_amount'] = $cart->total_ht;
        $cart->update([
            'delivery_id' => $request->deliver,
            'user_address_delivery' => $request->user_address_delivery,
            'user_address_invoice' => $request->user_address_invoice,
            'payment_id' => $payment_id,
        ]);

        /** Informations sur l'acheteur **/
        $user = User::findOrFail($cart->user_id);
        $payment_data['vads_cust_id'] = $user->id;
        $payment_data['vads_cust_name'] = $user->name;
        $payment_data['vads_cust_first_name'] = $user->first_name;
        $payment_data['vads_cust_last_name'] = $user->last_name;
        $payment_data['vads_cust_email'] = $user->email;
        $payment_data['vads_cust_phone'] = $user->phone;

        /** Traitement des redirections après tentative de paiement **/
        $payment_data['vads_url_cancel'] = route('orders.failed');
        $payment_data['vads_url_error'] = route('orders.failed');
        $payment_data['vads_url_refused'] = route('orders.failed');
        $payment_data[ 'vads_url_success'] = route('orders.success');

        /** Toujours générer la signature en dernier **/
        $payment_data['signature'] = generateSignature( $payment_data );

        return $this->redirectToExternalUrl(config('payment.redirect_url'), $payment_data);
    }



    private function redirectToExternalUrl($url, $data)
    {
        $formInputs = '';
        foreach ($data as $key => $value) {
            $formInputs .= '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
        }

        $html = '<html>
                    <body>
                        <form id="redirectForm" method="POST" action="' . htmlspecialchars($url) . '">
                            <input type="hidden" name="urlreturnvalid" value="1">
                            ' . $formInputs . '
                        </form>
                        <script type="text/javascript">
                            document.getElementById("redirectForm").submit();
                        </script>
                    </body>
                </html>';

        return response($html);
    }


    public function getPaymentReturn(Request $request)
    {

        if ($request->vads_auth_result == 00) {
            $this->cart_validation($request->vads_trans_id);
            // Ensure the order has been created before calling exportOrderInfos
            $order = Orders::where('payment_id', '=', $request->vads_trans_id)->first();

            if ($order) {
                // Call the export function only if the order exists
                //cookie()->queue(cookie()->forget('session_id'));
                Cookie::queue(Cookie::forget('session_id'));
                $this->exportOrderCSV($request->vads_trans_id);
                return 'Order '.$request->vads_trans_id.' created and exported successfully';
            } else {
                // Handle the error if the order was not created successfully
                return response()->json(['error' => 'Order creation failed'], 500);
            }
        } else {
            return 'Erreur';
        }
    }

    public function exportOrderCSV($payment_id) {
        $order = Orders::where('payment_id', '=', $payment_id)->first();
        $list = [$order->toArray()];

        $filename = 'export_order_'.date('Y_m_d_H_i_s').'_transaction_'.$order->payment_id.'.csv';

        // Ajoutez des en-têtes pour chaque colonne dans le téléchargement CSV
        array_unshift($list, array_keys($list[0]));

        // Générer le contenu CSV
        $csvContent = '';
        $callback = function() use ($list, &$csvContent) {
            $FH = fopen('php://temp', 'r+');
            foreach ($list as $row) {
                fputcsv($FH, $row, ';');
            }
            rewind($FH);
            $csvContent = stream_get_contents($FH);
            fclose($FH);
        };

        $callback();

        // Utilisez le système de fichiers pour stocker le fichier CSV
        Storage::disk('local')->put('exports/orders/'.$filename, $csvContent);
    }

    /* Enregistrement des toutes les informations de la commande avec le paiement
    public function cart_validation($payment_id)
    {


        // Récuperation des informations du panier
        $cart = Carts::with('product')->where('payment_id', '=', $payment_id)->first();

        $order = new Orders;
        $user = User::findOrFail($cart->user_id);

        $order->status_id = 3; // 'paiement accepté'
        $order->total_ttc = $cart->total_ttc;
        $order->payment_id = $cart->payment_id;

        // Récuperation des informations de l'utilisateur
        $order->user_id = $cart->user_id;

        $order->user_name = $user->name;
        $order->user_email = $user->email;

        $order->user_loyality_used = $cart->loyality;
        if ($cart->loyality == 5) $order->user_loyality_points_used = 300;
        if ($cart->loyality == 10) $order->user_loyality_points_used = 500;
        if ($cart->loyality == 15) $order->user_loyality_points_used = 1000;

        // Récuperation des informations de la livraison
        $order->delivery_id = $cart->delivery_id;
        $order->delivery_price = $cart->delivery_price;
        $order->delivery_date = $cart->delivery_date;
        $order->delivery_slot = $cart->delivery_slot;

        /*** Champs pour l'adresse de livraison ***
        $address_delivery = Address::findOrFail($cart->user_address_delivery);
        $order->user_delivery_civilite = $address_delivery->civilite;
        $order->user_delivery_first_name = $address_delivery->first_name;
        $order->user_delivery_last_name = $address_delivery->last_name;
        $order->user_delivery_address = $address_delivery->address;
        $order->user_delivery_address2 = $address_delivery->address2;
        $order->user_delivery_cities = $address_delivery->cities;
        $order->user_delivery_phone = $address_delivery->phone;
        $order->user_delivery_other_phone = $address_delivery->other_phone;

        /*** Champs pour l'adresse de facturation ***
        if($cart->user_address_invoice != $cart->user_address_delivery) {
            $address_invoice = Address::findOrFail($cart->user_address_invoice);
            $order->user_invoice_civilite = $address_invoice->civilite;
            $order->user_invoice_first_name = $address_invoice->first_name;
            $order->user_invoice_last_name = $address_invoice->last_name;
            $order->user_invoice_address = $address_invoice->address;
            $order->user_invoice_address2 = $address_invoice->address2;
            $order->user_invoice_cities = $address_invoice->cities;
            $order->user_invoice_phone = $address_invoice->phone;
            $order->user_invoice_other_phone = $address_invoice->other_phone;
        }
        $order->save();
        /// Recuperation des informations produits + Mise a jour du stock
        foreach ($cart->product as $cart_product) {
            $orderProducts = new OrderProducts();
            $productInfo = Product::findOrFail($cart_product->product_id);
            $orderProducts->orders_id = $order->id;
            $orderProducts->carts_id = $cart_product->carts_id;
            $orderProducts->product_id = $cart_product->product_id;
            $orderProducts->erp_id = $productInfo->erp_id;
            $orderProducts->name = $productInfo->name;
            $orderProducts->short_description = $productInfo->short_description;
            $orderProducts->fav_image = $cart_product->fav_image;
            $orderProducts->barcode = $productInfo->barcode;
            $orderProducts->stock_unit = $productInfo->stock_unit;
            $orderProducts->weight_unit = $productInfo->weight_unit;
            $orderProducts->weight = $productInfo->weight;
            $orderProducts->price_ht = $cart_product->price_ht;
            $orderProducts->tva = $cart_product->tva;
            $orderProducts->price_ttc = $cart_product->price_ttc;
            $orderProducts->discount_id = $cart_product->discount_id;
            $orderProducts->discount_percentage = $cart_product->discount_percentage;
            $orderProducts->discount_fixed_price_ttc = $cart_product->discount_fixed_price_ttc;
            $orderProducts->quantity = $cart_product->quantity;
            $orderProducts->save();
            // Mise à jour stock
            if($orderProducts->stock_unit == 'unit') {
                $productInfo->stock = $productInfo->stock - ($cart_product->quantity * 1000);
                $productInfo->save();
            } elseif ($orderProducts->stock_unit == 'kg') {
                $productInfo->stock = $productInfo->stock - $cart_product->quantity;
                $productInfo->save();
            }
        }

        // Modification des points FID
        $user = User::findOrFail($cart->user_id);
        $user->erp_loyalty_points = $user->erp_loyalty_points - $order->user_loyality_points_used;
        $user->erp_loyalty_points = $user->erp_loyalty_points + round($cart->total_ttc / 100, 0);
        $user->save();

        $cart->status = 'Commander';
        $cart->save();
        Cookie::queue(Cookie::forget('session_id'));
        return $payment_id;
    }*/


    // Enregistrement des toutes les informations de la commande direct
    public function cart_validation(Request $request, ?string $payment_id  = 'PAYMENT_TEST')
    {
        $payment_test = false;
        if($payment_id == 'PAYMENT_TEST') {
            $payment_test = true;
            $payment_id = generateUniqueAn6();
            $cart = Carts::findOrFail($request->cart);
            $cart->update([
                'delivery_id' => $request->deliver,
                'user_address_delivery' => $request->user_address_delivery,
                'user_address_invoice' => $request->user_address_invoice,
                'payment_id' => $payment_id,
            ]);
        } else {
            $payment_id = $request->payment_id;
        }

        // Récuperation des informations du panier
        $cart = Carts::with('product')->where('id', '=', $request->cart)->first();

        $order = new Orders;
        $user = User::findOrFail($cart->user_id);

        $order->status_id = 3; // 'paiement accepté'
        $order->total_ttc = $cart->total_ttc;
        $order->payment_id = $cart->payment_id;

        // Récuperation des informations de l'utilisateur
        $order->user_id = $cart->user_id;

        $order->user_name = $user->name;
        $order->user_email = $user->email;

        // Récuperation des informations de la livraison
        $order->delivery_id = $cart->delivery_id;
        $order->delivery_price = $cart->delivery_price;

        /*** Champs pour l'adresse de livraison ***/
        $address_delivery = Address::findOrFail($request->user_address_delivery);
        $order->user_delivery_civilite = $address_delivery->civilite;
        $order->user_delivery_first_name = $address_delivery->first_name;
        $order->user_delivery_last_name = $address_delivery->last_name;
        $order->user_delivery_address = $address_delivery->address;
        $order->user_delivery_address2 = $address_delivery->address2;
        $order->user_delivery_cities = $address_delivery->cities;
        $order->user_delivery_phone = $address_delivery->phone;
        $order->user_delivery_other_phone = $address_delivery->other_phone;

        /*** Champs pour l'adresse de facturation ***/
        if($cart->user_address_invoice != $cart->user_address_delivery) {
            $address_invoice = Address::findOrFail($request->user_address_invoice);
            $order->user_invoice_civilite = $address_invoice->civilite;
            $order->user_invoice_first_name = $address_invoice->first_name;
            $order->user_invoice_last_name = $address_invoice->last_name;
            $order->user_invoice_address = $address_invoice->address;
            $order->user_invoice_address2 = $address_invoice->address2;
            $order->user_invoice_cities = $address_invoice->cities;
            $order->user_invoice_phone = $address_invoice->phone;
            $order->user_invoice_other_phone = $address_invoice->other_phone;
        }
        $order->payment_id = $payment_id;
        $order->save();
        /// Recuperation des informations produits + Mise a jour du stock
        foreach ($cart->product as $cart_product) {
            $orderProducts = new OrderProducts();
            $productInfo = Product::findOrFail($cart_product->product_id);
            $orderProducts->orders_id = $order->id;
            $orderProducts->carts_id = $cart_product->carts_id;
            $orderProducts->product_id = $cart_product->product_id;
            $orderProducts->erp_id = $productInfo->erp_id;
            $orderProducts->name = $productInfo->name;
            $orderProducts->short_description = $productInfo->short_description;
            $orderProducts->fav_image = $cart_product->fav_image;
            $orderProducts->barcode = $productInfo->barcode;
            $orderProducts->stock_unit = $productInfo->stock_unit;
            $orderProducts->weight_unit = $productInfo->weight_unit;
            $orderProducts->weight = $productInfo->weight;
            $orderProducts->price_ht = $cart_product->price_ht;
            $orderProducts->tva = $cart_product->tva;
            $orderProducts->price_ttc = $cart_product->price_ttc;
            $orderProducts->discount_id = $cart_product->discount_id;
            $orderProducts->discount_percentage = $cart_product->discount_percentage;
            $orderProducts->discount_fixed_price_ttc = $cart_product->discount_fixed_price_ttc;
            $orderProducts->quantity = $cart_product->quantity;
            $orderProducts->save();
            // Mise à jour stock
            if($orderProducts->stock_unit == 'unit') {
                $productInfo->stock = $productInfo->stock - ($cart_product->quantity * 1000);
                $productInfo->save();
            } elseif ($orderProducts->stock_unit == 'kg') {
                $productInfo->stock = $productInfo->stock - $cart_product->quantity;
                $productInfo->save();
            }
        }
        $cart->status = 'Commander';
        $cart->save();

        //envoie du mail
        $mailData = [
            'order_id' => $order->id,
            'payment_id' => $order->payment_id,
            'name' => $order->user_delivery_first_name . ' ' . $order->user_delivery_last_name,
            'email' => $order->user_email,
            'total_product' => count($cart->product),
            'total_ttc' => formatPriceToFloat($order->total_ttc),
        ];
        Mail::send(new NewOrderMail($mailData));

        $session_id = $request->session()->regenerate();
        Cookie::queue(Cookie::forget('session_id'));
        cookie()->queue(cookie()->forever('session_id', $session_id));

        if($payment_test == false) {
            return $payment_id;
        } else {
            return to_route('orders.success');
        }
    }

    public function orderValidated()
    {
        return view('frontend.orders.validated');
    }

    public function paymentFailedOrAbandonned() {
        $cart = Carts::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->first();
        return view('frontend.carts.summary', [
            'user_address' => Address::findOrFail($cart->user_address_delivery),
            'user_address_fac' => Address::findOrFail($cart->user_address_invoice),
            'cart' => $cart,
            'deliver' => $cart->delivery_id,
            'error_message' => 'Quelque chose ne s\'est pas passé comme prévu lors du paiement. Veuillez réessayer.'
        ]);
    }

}
