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
            'CHIEN' => [
                'HYGIENE' => [
                    'SOIN' => ['SHAMPOOINGS', 'LOTIONS', 'SPRAYS', 'LINGETTES'],
                    'ANTIPARASITAIRE' => ['REPULSIFS', 'INSECTICIDES'],
                ],
                'MATERIEL' => [
                    'JOUET' => ['BALLES', 'LATEX', 'PELUCHES', 'CHIOT', 'CORDES', 'CAOUTCHOU TPR'],
                    'BROSSERIE' => [],
                    'HABITAT' => ['CORBEILLES', 'TRANSPORTS', 'COUSSINS', 'ECUELLES'],
                    'SELLERIE' => ['COLLIERS', 'LAISSES', 'ENSEMBLES', 'HARNAIS', 'PIQUETS', 'MUSELIERES'],
                    'ACCESSOIRES' => [],
                ],
                'ALIMENT' => [
                    'CROQUETTES' => ['CHIOT', 'ADULTE', 'SENIOR', 'DIET'],
                    'SNACKS' => ['BISCUITS', 'STICKS', 'FILETS', 'FRIANDISES', 'OS À MACHER', 'EDUCATION'],
                    'COMPLEMENTS' => ['VITAMINES', 'HUILES'],
                    'HUMIDE' => ['DIET'],
                ],
            ],
        ];

        $this->createCategories($categories);
    }

    private function createCategories(array $categories, $parentId = 0)
    {
        $order = 0;
        foreach ($categories as $categoryName => $subcategories) {
            $category = Category::create([
                'name' => $categoryName,
                'slug' => '/' . Str::slug($categoryName),
                'category_id' => $parentId,
                'is_menu' => 1,
                'order' => $order,
            ]);
            $order += 1;

            if (is_array($subcategories)) {
                foreach ($subcategories as $subcategoryName => $subSubcategories) {
                    if (is_array($subSubcategories)) {
                        $this->createCategories([$subcategoryName => $subSubcategories], $category->id);
                    } else {
                        $subCategory = Category::create([
                            'name' => $subSubcategories,
                            'slug' => '/' . Str::slug($categoryName) . '/' . Str::slug($subSubcategories),
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
