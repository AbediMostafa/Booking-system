<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteVarsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_page_header_title_1' => 'required',
            'first_page_header_text_1' => 'required',
            'first_page_header_title_2' => 'required',
            'first_page_header_text_2' => 'required',
            'first_page_header_title_3' => 'required',
            'first_page_header_text_3' => 'required',
            'first_page_header_button_text' => 'required',
            'special_rooms_title' => 'required',
            'special_rooms_text' => 'required',
            'special_rooms_nav_special' => 'required',
            'special_rooms_nav_new' => 'required',
            'special_rooms_nav_discount' => 'required',
            'first_page_learning_title' => 'required',
            'first_page_learning_text' => 'required',
            'first_page_learning_button_text' => 'required',
            'first_page_collection_title' => 'required',
            'first_page_collection_text' => 'required',
            'first_page_collection_button_text' => 'required',
            'escape_room_count_text' => 'required',
            'collection_count_text' => 'required',
            'city_count_text' => 'required',
            'city_page_title' => 'required',
            'city_page_text' => 'required',
            'collection_page_title' => 'required',
            'collection_page_text' => 'required',
            'genre_page_title' => 'required',
            'genre_page_text' => 'required',
            'learning_page_title' => 'required',
            'learning_page_text' => 'required',
            'our_story_text' => 'required',
            'contact_us' => 'required',
            'rate_scariness' => 'required',
            'rate_room_decoration' => 'required',
            'rate_hobbiness' => 'required',
            'rate_creativeness' => 'required',
            'rate_mysteriness' => 'required',

        ];
    }

    public function attributes()
    {
        return [
            'first_page_header_title_1' => 'تیتر اول صفحه اول',
            'first_page_header_text_1' => 'متن اول صفحه اول',
            'first_page_header_title_2' => 'تیتر دو صفحه اول',
            'first_page_header_text_2' => 'متن دوم صفحه اول',
            'first_page_header_title_3' => 'تیتر سوم صحفه اول',
            'first_page_header_text_3' => 'متن سوم صفحه اول',
            'first_page_header_button_text' => 'دکمه اول صفحه اول',
            'special_rooms_title' => 'عنوان اتاق های ویژه',
            'special_rooms_text' => 'متن اتاق های ویژه',
            'special_rooms_nav_special' => 'عنوان اتاق های ویژه',
            'special_rooms_nav_new' => 'عنوان اتاق های جدید',
            'special_rooms_nav_discount' => 'عنوان اتاق های تخفیف دار',
            'first_page_learning_title' => 'تیتر بخش آموزش صفحه اول',
            'first_page_learning_text' => 'متن بخش آموزش صفحه اول',
            'first_page_learning_button_text' => 'دکمه بخش آموزش صفحه اول',
            'first_page_collection_title' => 'تیتر بخش همراهان صفحه اول',
            'first_page_collection_text' => 'متن بخش همراهان صفحه اول',
            'first_page_collection_button_text' => 'دکمه بخش همراهان صفحه اول',
            'escape_room_count_text' => 'تعداد اتاق فرار',
            'collection_count_text' => 'تعداد مجموعه',
            'city_count_text' => 'تعداد شهر',
            'city_page_title' => 'تیتر بنر صفحه شهرها',
            'city_page_text' => 'متن بنر صفحه شهرها',
            'collection_page_title' => 'تیتر بنر صفحه مجموعه ها',
            'collection_page_text' => 'متن بنر صفحه مجموعه ها',
            'genre_page_title' => 'تیتر بنر صفحه ژانرها',
            'genre_page_text' => 'متن بنر صفحه ژانرها',
            'learning_page_title' => 'تیتر بنر صفحه آموزش ها',
            'learning_page_text' => 'متن بنر صفحه آموزش ها',
            'our_story_text' => 'متن داستان ما',
            'contact_us' => 'متن تماس با ما',
            'rate_scariness' => 'عنوان اول امتیازدهی',
            'rate_room_decoration' => 'عنوان دوم امتیازدهی',
            'rate_hobbiness' => 'عنوان سوم امتیازدهی',
            'rate_creativeness' => 'عنوان چهارم امتیازدهی',
            'rate_mysteriness' => 'عنوان پنجم امتیازدهی',
        ];
    }
}
