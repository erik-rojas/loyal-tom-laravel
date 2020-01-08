<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagsTableSeeder extends Seeder
{

    public function run()
    {
        $tags = [
            'Active lifestyle',
            'Animals',
            'Art exhib',
            'Bakery',
            'Ballet',
            'Beach',
            'Beauty procedures',
            'Bodybuilding',
            'Cats',
            'Champagne',
            'Cheese',
            'Chocolate',
            'Cigars',
            'Cinema',
            'Coffee',
            'Cognac',
            'Cooking',
            'Craft beer',
            'Dogs',
            'Doing sports',
            'F1',
            'Fashion',
            'Fitness',
            'Flowers',
            'Food',
            'Football',
            'Fruits',
            'Gardening',
            'Gin',
            'Golf',
            'Grooming',
            'Handmade crafts',
            'Healthy diet',
            'High quality accessories',
            'Home Design',
            'Horse riding',
            'Ice Hockey',
            'Interesting places to eat',
            'Massage',
            'Motorbikes',
            'Music',
            'Music concerts',
            'New Gadgets',
            'Non-alcoholic drinks',
            'Old-timers',
            'Opera',
            'Outdoor',
            'Photography',
            'Reading books',
            'Red wine',
            'Rum',
            'Sailing',
            'Social responsibilty',
            'Spa',
            'Sports cars',
            'Sustainability',
            'Sweets',
            'Tea',
            'Technology',
            'Tequila',
            'Theatre',
            'Toys (children)',
            'Travel',
            'Vegan',
            'Vegetarian',
            'Vodka',
            'Watching sports',
            'Whiskey',
            'White wine',
            'Yoga',
        ];

        $tag = new Tag();
        $tag->name = 'Female';
        $tag->category = 'sex';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Male';
        $tag->category = 'sex';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Age 0-5';
        $tag->category = 'age';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Age 6-12';
        $tag->category = 'age';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Age 13-17';
        $tag->category = 'age';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Age 18-25';
        $tag->category = 'age';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Age 26-35';
        $tag->category = 'age';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Age 36-45';
        $tag->category = 'age';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Age 46-55';
        $tag->category = 'age';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Age 56-65';
        $tag->category = 'age';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Age 65+';
        $tag->category = 'age';
        $tag->save();


        foreach ($tags as $tag){
            $new_tag = new Tag();
            $new_tag->name = $tag;
            $new_tag->save();
        }

        $tag = new Tag();
        $tag->name = 'Switzerland';
        $tag->category = 'country';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Germany';
        $tag->category = 'country';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Zürich';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Bern';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Luzern';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Uri';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Schwyz';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Obwalden';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Nidwalden';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Glarus';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Zug';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Fribourg';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Solothurn';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Basel-Stadt';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Basel-Landschaft';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Schaffhausen';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Appenzell Ausserrhoden';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Appenzell Innerrhoden';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'St. Gallen';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Graubünden';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Aargau';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Thurgau';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Ticino';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Vaud';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Valais';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Neuchâtel';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Geneva';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Jura';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Baden-Württemberg';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Bavaria';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Berlin';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Brandenburg';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Bremen';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Hamburg';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Hesse';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Lower Saxony';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Mecklenburg-Vorpommern';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'North Rhine- Westphalia';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Rhineland-Palatinate';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Saarland';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Saxony';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Saxony-Anhalt';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Schleswig-Holstein';
        $tag->category = 'region';
        $tag->save();

        $tag = new Tag();
        $tag->name = 'Thuringia';
        $tag->category = 'region';
        $tag->save();


    }
}
