<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Catalog\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Chien' => [
                'Hygiène' => [
                    'Soin' => ['Shampooings', 'Lotions', 'Sprays', 'Lingettes'],
                    'Antiparasitaire' => ['Répulsifs', 'Insecticides'],
                ],
                'Matériel' => [
                    'Jouet' => ['Balles', 'Latex', 'Peluches', 'Chiot', 'Cordes', 'Caoutchouc TPR'],
                    'Brosserie' => [],
                    'Habitat' => ['Corbeilles', 'Transports', 'Coussins', 'Écuelles'],
                    'Sellerie' => ['Colliers', 'Laisses', 'Ensembles', 'Harnais', 'Piquets', 'Muselières'],
                    'Accessoires' => [],
                ],
                'Aliment' => [
                    'Croquettes' => ['Chiot', 'Adulte', 'Senior', 'Diet'],
                    'Snacks' => ['Biscuits', 'Sticks', 'Filets', 'Friandises', 'Os à mâcher', 'Éducation'],
                    'Compléments' => ['Vitamines', 'Huiles'],
                    'Humide' => ['Diet'],
                ],
            ],
        ];

        $this->createCategories($categories);
    }

    private function createCategories(array $categories, $parentId = 0, $parentSlug = '')
    {
        $order = 0;
        foreach ($categories as $categoryName => $subcategories) {
            $slug = ($parentSlug ? $parentSlug . '/' : '') . Str::slug($categoryName);

            $category = Category::create([
                'name' => $categoryName,
                'slug' => $slug,
                'category_id' => $parentId,
                'is_menu' => 1,
                'order' => $order,
            ]);
            $order += 1;

            if (is_array($subcategories)) {
                foreach ($subcategories as $subKey => $subValue) {
                    if (is_array($subValue)) {
                        $this->createCategories([$subKey => $subValue], $category->id, $slug);
                    } else {
                        $subSlug = $slug . '/' . Str::slug($subValue);
                        Category::create([
                            'name' => $subValue,
                            'slug' => $subSlug,
                            'category_id' => $category->id,
                            'is_menu' => 1,
                            'order' => $order,
                        ]);
                        $order += 1;
                    }
                }
            }
        }
    }
}
