<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Genre;
use App\Models\Like;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Region;
use App\Models\Review;
use App\Models\Upvote;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // seed genres
        Genre::factory()->create([
            'en_name' => 'Arabic Books',
            'fr_name' => 'Livres arabes',
            'ar_name' => 'الكتب العربية',
            'fa_icon' => 'fa-solid fa-book'
        ]);

        Genre::factory()->create([
            'en_name' => 'Arabic Novels',
            'fr_name' => 'Romans arabes',
            'ar_name' => 'الروايات العربية',
            'fa_icon' => 'fa-solid fa-book'
        ]);

        Genre::factory()->create([
            'en_name' => 'Religion Books',
            'fr_name' => 'Livres religieux',
            'ar_name' => 'الكتب الدينية',
            'fa_icon' => 'fa-solid fa-book'
        ]);

        // seed regions
        Region::factory()->create(['fr_name' => 'Adrar', 'ar_name' => 'أدرار']);
        Region::factory()->create(['fr_name' => 'Chlef', 'ar_name' => 'الشلف']);
        Region::factory()->create(['fr_name' => 'Laghouat', 'ar_name' => 'الأغواط']);
        Region::factory()->create(['fr_name' => 'Oum el-Bouaghi', 'ar_name' => 'أم البواقي']);
        Region::factory()->create(['fr_name' => 'Batna', 'ar_name' => 'باتنة']);
        Region::factory()->create(['fr_name' => 'Béjaïa', 'ar_name' => 'بجاية']);
        Region::factory()->create(['fr_name' => 'Biskra', 'ar_name' => 'بسكرة']);
        Region::factory()->create(['fr_name' => 'Béchar', 'ar_name' => 'بشار']);
        Region::factory()->create(['fr_name' => 'Blida', 'ar_name' => 'البليدة']);
        Region::factory()->create(['fr_name' => 'Bouira', 'ar_name' => 'البويرة']);
        Region::factory()->create(['fr_name' => 'Tamanrasset', 'ar_name' => 'تمنراست']);
        Region::factory()->create(['fr_name' => 'Tébessa', 'ar_name' => 'تبسة']);
        Region::factory()->create(['fr_name' => 'Tlemcen', 'ar_name' => 'تلمسان']);
        Region::factory()->create(['fr_name' => 'Tiaret', 'ar_name' => 'تيارت']);
        Region::factory()->create(['fr_name' => 'Tizi Ouzou', 'ar_name' => 'تيزي وزو']);
        Region::factory()->create(['fr_name' => 'Algiers', 'ar_name' => 'الجزائر']);
        Region::factory()->create(['fr_name' => 'Djelfa', 'ar_name' => 'الجلفة']);
        Region::factory()->create(['fr_name' => 'Jijel', 'ar_name' => 'جيجل']);
        Region::factory()->create(['fr_name' => 'Sétif', 'ar_name' => 'سطيف']);
        Region::factory()->create(['fr_name' => 'Saïda', 'ar_name' => 'سعيدة']);
        Region::factory()->create(['fr_name' => 'Skikda', 'ar_name' => 'سكيكدة']);
        Region::factory()->create(['fr_name' => 'Sidi Bel Abbès', 'ar_name' => 'سيدي بلعباس']);
        Region::factory()->create(['fr_name' => 'Annaba', 'ar_name' => 'عنابة']);
        Region::factory()->create(['fr_name' => 'Guelma', 'ar_name' => 'قالمة']);
        Region::factory()->create(['fr_name' => 'Constantine', 'ar_name' => 'قسنطينة']);
        Region::factory()->create(['fr_name' => 'Médéa', 'ar_name' => 'المدية']);
        Region::factory()->create(['fr_name' => 'Mostaganem', 'ar_name' => 'مستغانم']);
        Region::factory()->create(['fr_name' => 'M\'Sila', 'ar_name' => 'المسيلة']);
        Region::factory()->create(['fr_name' => 'Mascara', 'ar_name' => 'معسكر']);
        Region::factory()->create(['fr_name' => 'Ouargla', 'ar_name' => 'ورقلة']);
        Region::factory()->create(['fr_name' => 'Oran', 'ar_name' => 'وهران']);
        Region::factory()->create(['fr_name' => 'El Bayadh', 'ar_name' => 'البيض']);
        Region::factory()->create(['fr_name' => 'Illizi', 'ar_name' => 'إليزي']);
        Region::factory()->create(['fr_name' => 'Bordj Bou Arréridj', 'ar_name' => 'برج بوعريريج']);
        Region::factory()->create(['fr_name' => 'Boumerdès', 'ar_name' => 'بومرداس']);
        Region::factory()->create(['fr_name' => 'El Tarf', 'ar_name' => 'الطارف']);
        Region::factory()->create(['fr_name' => 'Tindouf', 'ar_name' => 'تندوف']);
        Region::factory()->create(['fr_name' => 'Tissemsilt', 'ar_name' => 'تيسمسيلت']);
        Region::factory()->create(['fr_name' => 'El Oued', 'ar_name' => 'الوادي']);
        Region::factory()->create(['fr_name' => 'Khenchela', 'ar_name' => 'خنشلة']);
        Region::factory()->create(['fr_name' => 'Souk Ahras', 'ar_name' => 'سوق أهراس']);
        Region::factory()->create(['fr_name' => 'Tipasa', 'ar_name' => 'تيبازة']);
        Region::factory()->create(['fr_name' => 'Mila', 'ar_name' => 'ميلة']);
        Region::factory()->create(['fr_name' => 'Aïn Defla', 'ar_name' => 'عين الدفلى']);
        Region::factory()->create(['fr_name' => 'Naâma', 'ar_name' => 'النعامة']);
        Region::factory()->create(['fr_name' => 'Aïn Témouchent', 'ar_name' => 'عين تموشنت']);
        Region::factory()->create(['fr_name' => 'Ghardaïa', 'ar_name' => 'غرداية']);
        Region::factory()->create(['fr_name' => 'Relizane', 'ar_name' => 'غليزان']);
        Region::factory()->create(['fr_name' => 'Timimoun', 'ar_name' => 'تيميمون']);
        Region::factory()->create(['fr_name' => 'Bordj Badji Mokhtar', 'ar_name' => 'برج باجي مختار']);
        Region::factory()->create(['fr_name' => 'Ouled Djellal', 'ar_name' => 'أولاد جلال']);
        Region::factory()->create(['fr_name' => 'Béni Abbès', 'ar_name' => 'بني عباس']);
        Region::factory()->create(['fr_name' => 'In Salah', 'ar_name' => 'عين صالح']);
        Region::factory()->create(['fr_name' => 'In Guezzam', 'ar_name' => 'عين قزام']);
        Region::factory()->create(['fr_name' => 'Touggourt', 'ar_name' => 'تقرت']);
        Region::factory()->create(['fr_name' => 'Djanet', 'ar_name' => 'جانت']);
        Region::factory()->create(['fr_name' => 'El M\'Ghair', 'ar_name' => 'المغير']);
        Region::factory()->create(['fr_name' => 'El Meniaa', 'ar_name' => 'المنيعة']);
        Region::factory()->create(['fr_name' => 'Aflou', 'ar_name' => 'أفلو']); // 59
        Region::factory()->create(['fr_name' => 'El Abiodh Sidi Cheikh', 'ar_name' => 'الأبيض سيدي الشيخ']); // 60
        Region::factory()->create(['fr_name' => 'El Aricha', 'ar_name' => 'العريشة']); // 61
        Region::factory()->create(['fr_name' => 'El Kantara', 'ar_name' => 'القنطرة']); // 62
        Region::factory()->create(['fr_name' => 'Barika', 'ar_name' => 'بريكة']); // 63
        Region::factory()->create(['fr_name' => 'Bou Saâda', 'ar_name' => 'بوسعادة']); // 64
        Region::factory()->create(['fr_name' => 'Bir El Ater', 'ar_name' => 'بئر العاتر']); // 65
        Region::factory()->create(['fr_name' => 'Ksar El Boukhari', 'ar_name' => 'قصر البخاري']); // 66
        Region::factory()->create(['fr_name' => 'Ksar Chellala', 'ar_name' => 'قصر الشلالة']); // 67
        Region::factory()->create(['fr_name' => 'Aïn Oussara', 'ar_name' => 'عين وسارة']); // 68
        Region::factory()->create(['fr_name' => 'Messaad', 'ar_name' => 'مسعد']); // 69

        // seed order statuses
        OrderStatus::factory()->create(['en_message' => 'Processing' , 'ar_message' => 'قيد المعالجة', 'fr_message' => 'En cours de traitement']);
        OrderStatus::factory()->create(['en_message' => 'Delivering' , 'ar_message' => 'قيد الإرسال', 'fr_message' => 'En cours de livraison']);
        OrderStatus::factory()->create(['en_message' => 'Delivered' , 'ar_message' => 'تم التسليم', 'fr_message' => 'Livrée']);
        OrderStatus::factory()->create(['en_message' => 'Canceled' , 'ar_message' => 'تم إلغاؤه', 'fr_message' => 'Annulée']);
        OrderStatus::factory()->create(['en_message' => 'Returned' , 'ar_message' => 'تم إرجاعه', 'fr_message' => 'Retourée']);

        // seed admin user
        $regions = Region::all();
        User::factory()->create([
            'name' => 'Sohaib Khiaf',
            'email' => 'sohaibkhiaf@gmail.com',
            'phone' => '0659595372',
            'address' => '150 LOGTS Bejaoui El-Alia Biskra',
            'age' => '25',
            'gender' => 1,
            'role' => 1,
            'region_id' => '07',
        ]);

        // seed users
        for($i =0; $i < 50; $i++){
            User::factory()->randomAgeBetween(10, 80)->create([
                'region_id' => $regions->random()->id,
            ]);
        }

        // seed books

        $categories = Genre::all();

        Book::factory()->create([
            'title' => 'قوانين التحرر من الصراع النفسي',
            'author' => 'د. يوسف الحسني',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 1700,
            'discount' => 0,
            'quantity' => 50,
            'image_url' => 'books/book-1.jpg',
            'bestseller' => false,
            'bookshelf' => true,
            'genre_id' => $categories->find(1)->id,
        ]);

        Book::factory()->create([
            'title' => 'محاط بالحمقى',
            'author' => 'توماس إريكسون',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 1250,
            'discount' => 0,
            'quantity' => 20,
            'image_url' => 'books/book-2.png',
            'bestseller' => false,
            'bookshelf' => true,
            'genre_id' => $categories->find(1)->id,
        ]);

        Book::factory()->create([
            'title' => 'رسائل من القرآن',
            'author' => 'أدهم شرقاوي',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 1300,
            'discount' => 1000,
            'quantity' => 100,
            'image_url' => 'books/book-3.jpg',
            'bestseller' => true,
            'bookshelf' => true,
            'genre_id' => $categories->find(3)->id,
        ]);

        Book::factory()->create([
            'title' => 'أرض زيكولا',
            'author' => 'عمرو عبد الحميد',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 850,
            'discount' => 0,
            'quantity' => 250,
            'image_url' => 'books/book-4.jpg',
            'bestseller' => true,
            'bookshelf' => true,
            'genre_id' => $categories->find(2)->id,
        ]);

        Book::factory()->create([
            'title' => 'أماريتا',
            'author' => 'عمرو عبد الحميد',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 950,
            'discount' => 0,
            'quantity' => 250,
            'image_url' => 'books/book-5.jpg',
            'bestseller' => false,
            'bookshelf' => false,
            'genre_id' => $categories->find(2)->id,
        ]);

        Book::factory()->create([
            'title' => 'وادي الذئاب المنسية',
            'author' => 'عمرو عبد الحميد',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 1000,
            'discount' => 0,
            'quantity' => 250,
            'image_url' => 'books/book-6.jpg',
            'bestseller' => false,
            'bookshelf' => false,
            'genre_id' => $categories->find(2)->id,
        ]);

        Book::factory()->create([
            'title' => 'الأب الغني والأب الفقير',
            'author' => 'روبرت كيوساكي',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 900,
            'discount' => 0,
            'quantity' => 50,
            'image_url' => 'books/book-7.jpg',
            'bestseller' => false,
            'bookshelf' => false,
            'genre_id' => $categories->find(1)->id,
        ]);

        Book::factory()->create([
            'title' => 'خطة تسويق في صفحة واحدة',
            'author' => 'ألن ديب',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 1500,
            'discount' => 0,
            'quantity' => 20,
            'image_url' => 'books/book-8.jpg',
            'bestseller' => false,
            'bookshelf' => false,
            'genre_id' => $categories->find(1)->id,
        ]);

        Book::factory()->create([
            'title' => 'سيروش',
            'author' => 'د. حنان لاشين',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 1400,
            'discount' => 0,
            'quantity' => 20,
            'image_url' => 'books/book-9.jpg',
            'bestseller' => false,
            'bookshelf' => false,
            'genre_id' => $categories->find(2)->id,
        ]);

        Book::factory()->create([
            'title' => 'فن اللامبالاة',
            'author' => 'مارك مانسون',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 900,
            'discount' => 0,
            'quantity' => 20,
            'image_url' => 'books/book-10.jpg',
            'bestseller' => true,
            'bookshelf' => false,
            'genre_id' => $categories->find(1)->id,
        ]);

        Book::factory()->create([
            'title' => 'نادي الخامسة صباحا',
            'author' => 'روبن شارما',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 1200,
            'discount' => 0,
            'quantity' => 10,
            'image_url' => 'books/book-11.jpg',
            'bestseller' => false,
            'bookshelf' => false,
            'genre_id' => $categories->find(1)->id,
        ]);

        Book::factory()->create([
            'title' => 'الوحش الذي يسكنك يمكن أن يكون لطيفا',
            'author' => 'إيناس سمير',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 1350,
            'discount' => 0,
            'quantity' => 10,
            'image_url' => 'books/book-12.jpg',
            'bestseller' => false,
            'bookshelf' => false,
            'genre_id' => $categories->find(1)->id,
        ]);

        Book::factory()->create([
            'title' => 'عقدك النفسية سكنك الأبدي',
            'author' => 'د. يوسف الحسني',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 1100,
            'discount' => 0,
            'quantity' => 200,
            'image_url' => 'books/book-13.jpg',
            'bestseller' => true,
            'bookshelf' => false,
            'genre_id' => $categories->find(1)->id,
        ]);

        Book::factory()->create([
            'title' => 'العادات الذرية',
            'author' => 'جيمس كلير',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 950,
            'discount' => 0,
            'quantity' => 50,
            'image_url' => 'books/book-14.jpg',
            'bestseller' => false,
            'bookshelf' => false,
            'genre_id' => $categories->find(1)->id,
        ]);

        Book::factory()->create([
            'title' => 'أغنى رجل في بابل',
            'author' => 'جورج كلاسون',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 800,
            'discount' => 0,
            'quantity' => 50,
            'image_url' => 'books/book-15.jpg',
            'bestseller' => false,
            'bookshelf' => false,
            'genre_id' => $categories->find(1)->id,
        ]);

        Book::factory()->create([
            'title' => 'من الذي حرك قطعة الجبن الخاصة بي',
            'author' => 'جورج كلاسون',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 700,
            'discount' => 0,
            'quantity' => 20,
            'image_url' => 'books/book-16.jpg',
            'bestseller' => false,
            'bookshelf' => false,
            'genre_id' => $categories->find(1)->id,
        ]);

        Book::factory()->create([
            'title' => '48 قانون للقوة',
            'author' => 'روبرت غرين',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 2200,
            'discount' => 1900,
            'quantity' => 500,
            'image_url' => 'books/book-17.jpg',
            'bestseller' => true,
            'bookshelf' => false,
            'genre_id' => $categories->find(1)->id,
        ]);

        Book::factory()->create([
            'title' => 'كن الشخص الذي يجعلك سعيدا',
            'author' => 'إناس سمير',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 900,
            'discount' => 0,
            'quantity' => 20,
            'image_url' => 'books/book-18.png',
            'bestseller' => false,
            'bookshelf' => false,
            'genre_id' => $categories->find(1)->id,
        ]);


        Book::factory()->create([
            'title' => 'قوة العادات',
            'author' => 'تشارلز دويج',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 1200,
            'discount' => 0,
            'quantity' => 10,
            'image_url' => 'books/book-19.jpg',
            'bestseller' => false,
            'bookshelf' => false,
            'genre_id' => $categories->find(1)->id,
        ]);

        Book::factory()->create([
            'title' => 'لا يمكن إيذائي',
            'author' => 'ديفيد غوغنز',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 1400,
            'discount' => 0,
            'quantity' => 5,
            'image_url' => 'books/book-20.jpg',
            'bestseller' => false,
            'bookshelf' => false,
            'genre_id' => $categories->find(1)->id,
        ]);

        Book::factory()->create([
            'title' => 'العادات السبع للناس الأكثر فعالية',
            'author' => 'ستيفن آر. كوفي',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 1300,
            'discount' => 0,
            'quantity' => 5,
            'image_url' => 'books/book-21.jpg',
            'bestseller' => false,
            'bookshelf' => false,
            'genre_id' => $categories->find(1)->id,
        ]);

        Book::factory()->create([
            'title' => 'كيف تبيع أي شيء لأي إنسان',
            'author' => 'جو جيرارد',
            'description' => 'لوريم إيبسوم دولر سيت أميت، كونسيكتيتور أديبيسسينغ إيليت. كونفاليس نولام كورسوس إيليت؛ ماسا كويزكي أليكويت إيو إيوزمود نيسي. بلاتيا ناتوك دينيسيم نيتوس؛ كونوبيا كورسوس ديام دونك. مي فيتاي ليتورا؛ كويز دوي لاكوس مايسيناس.',
            'price' => 1000,
            'discount' => 0,
            'quantity' => 25,
            'image_url' => 'books/book-22.jpg',
            'bestseller' => false,
            'bookshelf' => false,
            'genre_id' => $categories->find(1)->id,
        ]);

        // seed orders
        $users = User::all();
        $orderStatuses = OrderStatus::all();
        for($i =0; $i < 150; $i++){
            Order::factory()->randomShippingType()->create([
                'user_id' => $users->random()->id,
                'order_status_id' => $orderStatuses->random()->id,
            ]);
        }

        // seed order details
        $orders = Order::all();
        $books = Book::all();
        foreach($orders as $order){
            for($i =0; $i < rand(1, 5); $i++){
                OrderDetail::factory()->create([
                    'book_id'=> $books->random()->id,
                    'order_id' => $order->id,
                ]);
            }
        }

        // seed likes
        for($i =0; $i < 1000; $i++){
            Like::factory()->create([
                'user_id' => $users->random()->id,
                'book_id' => $books->random()->id,
            ]);
        }

        // seed reviews
        for($i =0; $i < 162; $i++){
            Review::factory()->randomLanguage()
                ->randomPubStatus()
                ->randomEditedStatus()
                ->create([
                'user_id' => $users->random()->id,
                'book_id' => $books->random()->id,
            ]);
        }

        // seed upvotes
        $reviews = Review::all();
        for($i =0; $i < 620; $i++){
            Upvote::factory()->create([
                'user_id' => $users->random()->id,
                'review_id' => $reviews->random()->id,
            ]);
        }

    }
}
