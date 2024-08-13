<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Article::insert([
            [
                'name' => 'THIS IS A STANDARD POST WITH A PREVIEW IMAGE',
                'slug' => $this->convert_to_slug('THIS IS A STANDARD POST WITH A PREVIEW IMAGE'),
                'contents' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, asperiores quod est tenetur in. Eligendi, deserunt, blanditiis est quisquam doloribus voluptate id aperiam ea ipsum magni aut perspiciatis rem voluptatibus officia eos rerum deleniti quae nihil facilis repellat atque vitae voluptatem libero at eveniet veritatis ab facere.',
                'teaser' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'status' => 'Published',
                'is_featured' => '1',
                'user_id' => '1',
                'image_url' => \URL::to('/').'/theme/images/news/news1.jpg',
                'thumbnail_url' => \URL::to('/').'/theme/images/news/news1.jpg',
                'meta_title' => 'title',
                'meta_keyword' => 'keyword',
                'meta_description' => 'description',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'THIS IS A STANDARD POST WITH A PREVIEW IMAGE-2',
                'slug' => $this->convert_to_slug('THIS IS A STANDARD POST WITH A PREVIEW IMAGE-2'),
                'contents' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, asperiores quod est tenetur in. Eligendi, deserunt, blanditiis est quisquam doloribus voluptate id aperiam ea ipsum magni aut perspiciatis rem voluptatibus officia eos rerum deleniti quae nihil facilis repellat atque vitae voluptatem libero at eveniet veritatis ab facere.',
                'teaser' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'status' => 'Published',
                'is_featured' => '1',
                'user_id' => '1',
                'image_url' => \URL::to('/').'/theme/images/news/news2.jpg',
                'thumbnail_url' => \URL::to('/').'/theme/images/news/news2.jpg',
                'meta_title' => 'title',
                'meta_keyword' => 'keyword',
                'meta_description' => 'description',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'name' => 'THIS IS A STANDARD POST WITH A PREVIEW IMAGE-3',
                'slug' => $this->convert_to_slug('THIS IS A STANDARD POST WITH A PREVIEW IMAGE-3'),
                'contents' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate, asperiores quod est tenetur in. Eligendi, deserunt, blanditiis est quisquam doloribus voluptate id aperiam ea ipsum magni aut perspiciatis rem voluptatibus officia eos rerum deleniti quae nihil facilis repellat atque vitae voluptatem libero at eveniet veritatis ab facere.',
                'teaser' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
                'status' => 'Published',
                'is_featured' => '1',
                'user_id' => '1',
                'image_url' => \URL::to('/').'/theme/images/news/news3.jpg',
                'thumbnail_url' => \URL::to('/').'/theme/images/news/news3.jpg',
                'meta_title' => 'title',
                'meta_keyword' => 'keyword',
                'meta_description' => 'description',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]
        ]);
    }

    public function convert_to_slug($url){

        $url = Str::slug($url, '-');

        if (\App\Models\Page::where('slug', '=', $url)->exists()) {
            $url = $url."_2";
        }
        elseif (\App\Models\Article::where('slug', '=', $url)->exists()) {
            $url = $url."_2";
        }

        return $url;
    }
}
