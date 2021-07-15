<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteVariables extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_variables')->insert([

            //carousel items
            [
                'variable'=>'first_page_header_title_1',
                'value'=>'لذت ترس به همراه فرار'

            ],
            [
                'variable'=>'first_page_header_text_1',
                'value'=>'سخت تایپ به پایان رسد و زمان مورد نیاز شامل حروفچینی دستاوردهای اصلی، و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیر'
            ],
            [
                'variable'=>'first_page_header_title_2',
                'value'=>'مهیج ترین اتاق های فرار'

            ],
            [
                'variable'=>'first_page_header_text_2',
                'value'=>'متن دوم'
            ],
            [
                'variable'=>'first_page_header_title_3',
                'value'=>'دسترسی سریع به اتاق های فرار'

            ],
            [
                'variable'=>'first_page_header_text_3',
                'value'=>'متن سوم'
            ],
            [
                'variable'=>'first_page_header_button_text',
                'value'=>'شروع ماجراجویی'
            ],

            //special rooms
            [
                'variable'=>'special_rooms_title',
                'value'=>'اتاق های ویژه با'
            ],
            [
                'variable'=>'special_rooms_text',
                'value'=>'بعضی از اتاق ها تخفیف های مناسبی دارن و یا بعضیاشون پیشنهادهای ویژه ما هستن، یا بعضی از اتاق ها تازه درست شدن'
            ],

            //special room navbar
            [
                'variable'=>'special_rooms_nav_special',
                'value'=>'پیشنهاد ویژه'
            ],
            [
                'variable'=>'special_rooms_nav_new',
                'value'=>'تازه ها'
            ],
            [
                'variable'=>'special_rooms_nav_discount',
                'value'=>'تخفیفی ها'
            ],

            //first page learning
            [
                'variable'=>'first_page_learning_title',
                'value'=>'آموزش با'
            ],
            [
                'variable'=>'first_page_learning_text',
                'value'=>'بعضی وقت ها توی بعضی از اتاق ها به مواردی برمیخوری که نیاز به اطلاعات قبلی داره. اطلاعاتی را جع به اتاق ها و انواع کلیدها. ما توی این بخش یه سری آموزش ها رو به شما میدیم که بیشتر از اتاق ها لذت ببرید'
            ],
            [
                'variable'=>'first_page_learning_button_text',
                'value'=>'همه آموزش ها'
            ],

            //first page collections
            [
                'variable'=>'first_page_collection_title',
                'value'=>'همراهان'
            ],
            [
                'variable'=>'first_page_collection_text',
                'value'=>'هر کدام از کالکشن ها و یا شرکت های اتاق فرار چند اتاق فرار را مدیریت می کنند که ممکن است در هر کجای کشور باشند. این کالکشن ها به سرعت در حال ازدیاد هستند. شما می توانید به کالکشن ها مراجعه و از اتاق های آنها لذت ببرید'
            ],
            [
                'variable'=>'first_page_collection_button_text',
                'value'=>'همه برندهای اتاق فرار'
            ],

            // entity counts
            [
                'variable'=>'escape_room_count_text',
                'value'=>'500'
            ],
            [
                'variable'=>'collection_count_text',
                'value'=>'110'
            ],
            [
                'variable'=>'city_count_text',
                'value'=>'17'
            ],

            //city page 
            [
                'variable'=>'city_page_title',
                'value'=>'همه شهرهای دارای اتاق فرار'
            ],
            [
                'variable'=>'city_page_text',
                'value'=>'بیش از 40 شهر و 250 اتاق فرار.با اتاق های فرار سرگرمی های مناسبی برای خودتان فراهم کنید و از ساعات مناسب برای خود لذت ببرید'
            ],
 
            //collection page
            [
                'variable'=>'collection_page_title',
                'value'=>'همه برندهای اتاق فرار'
            ],
            [
                'variable'=>'collection_page_text',
                'value'=>'بیش از 40 شهر و 250 اتاق فرار.با اتاق های فرار سرگرمی های مناسبی برای خودتان فراهم کنید و از ساعات مناسب برای خود لذت ببرید'
            ],

            //genre page
            [
                'variable'=>'genre_page_title',
                'value'=>'اتاق های فرار'
            ],
            [
                'variable'=>'genre_page_text',
                'value'=>'همه اتاق های فرار بر اساس فیلترهایی تقسیم بندی شده اند. با استفاده از این فیلترها می توانید اتاق مورد نظر خود را پیدا کنید که در شهر خاص، مجموعه خاص و یا ژانر خاص وجود دارند'
            ],

            //learning page
            [
                'variable'=>'learning_page_title',
                'value'=>'همه آموزش ها'
            ],
            [
                'variable'=>'learning_page_text',
                'value'=>'بعضی از وقت ها توی اتاق های فرار نیاز به اطلاعاتی داری که قبلا باید یکی بهت میگفت. ما اینجا سعی کردیم این آموزش ها رو به شما بدیم'
            ],

            //our story
            [
                'variable'=>'our_story_text',
                'value'=>'
                    ما تیم میس اسکیپ هستیم
                '
            ],
            [
                'variable'=>'contact_us',
                'value'=>'
                    تلفن: 220 79654
                '
            ],

            //rate item titles
            [
                'variable'=>'rate_scariness',
                'value'=>'درجه ترس'
            ],
            [
                'variable'=>'rate_room_decoration',
                'value'=>'طراحی اتاق'
            ],
            [
                'variable'=>'rate_hobbiness',
                'value'=>'درجه سرگرمی'
            ],
            [
                'variable'=>'rate_creativeness',
                'value'=>'خلاقیت'
            ],
            [
                'variable'=>'rate_mysteriness',
                'value'=>'جذابیت داستان'
            ],
        ]);
    }
}
