<?php
class Model_group
{
    public static function index($id)
    {
        $data  = [];

        $lang_text = Service_text::get_message_text();

        $region = Core::get("/regions/readOne.php?", ['region_id' => $id]);
        $button_back = Service_buttons::back($lang_text['button_back_text'], 'back_start');
        if ($region['active']) {
            for ($i = 1; $i <= $region['number_groups']; $i++) {
                $buttons_group[] = [
                    'text' => "Група $i",
                    'callback_data' => "group_$i"
                ];
            } 

            $data = [
                'text' =>  $lang_text['title_create_group'],
                'buttons' => $buttons_group,
                'button_merge' => $button_back
            ];
        } else {
            $text = $lang_text['text_region_none_active'];


            if ($region['status'] == "free") {
                $text .= $lang_text['text_region_free'];
                $buttons_group = [
                    [
                        "text" => $lang_text['button_oficial_site'],
                        "url"  => $region['site']
                    ],
                    [
                        "text" => $lang_text['button_facebook'],
                        "url"  => $region['facebook']
                    ]
                ];
            }

            if ($region['alert']) {
                $text .= $region['alert'];
            }  

            $data = [
                'text' =>  $text,
                'buttons' => (array)$buttons_group,
                'button_merge' => $button_back
            ];
        }

        return $data;
    }
}
