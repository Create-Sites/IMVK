<?php

namespace CreateSites\IMVK\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use CreateSites\IMVK\Models\IMVK;
use CreateSites\IMVK\Models\IMVKMessages;
use CreateSites\IMVK\Events\SendIMVKMessage;
use Auth;

class IMVKController extends Controller
{
    /**
     * show all dialogs
     *
     * @param IMVK $im
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(IMVK $im)
    {
        $user = Auth::user();
        $this->data['ims'] = $im->allMessages($user->id);

        return view('crsites_im::index', $this->data);
    }

    /**
     * show all messages for user
     *
     * @param $from_user_id
     * @param IMVKMessages $messages
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function messages($from_user_id, IMVKMessages $messages)
    {
        $user = Auth::user();
        $for_user = User::find($from_user_id);

        $this->data['messages'] = $messages->userMessages($user->id, $from_user_id);
        $this->data['for_user'] = $for_user;
        $this->data['from_user'] = $user;

        return view('crsites_im::show', $this->data);
    }

    /**
     * Send a message by Javascript and save in database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request)
    {
        $user = Auth::user();

        //Проверка на наличии созданого диалога у себя
        $im = IMVK::where('user_id', $user->id)
            ->where('im_user_id', $request->for_user_id)
            ->first();

        if ($im != null) :

                //Проверка на наличии созданого диалога у себя
                if ($im->user_id == $user->id && $im->im_user_id == $request->for_user_id) :

                    $im_num = $im->all_msg_num + 1;
                    $im->all_msg_num = $im_num;

                    $im->save();
                endif;

        else :

            //созданого диалога у себя
            $im = new IMVK;

            $im->user_id = $user->id;
            $im->im_user_id = $request->for_user_id;
            $im->all_msg_num = 1;

            $im->save();
            $im->user()->attach($request->for_user_id);

        endif;

        //Проверка на наличии созданого диалога у получателя
        $imf = IMVK::where('user_id', $request->for_user_id)
            ->where('im_user_id', $user->id)
            ->first();

        if ($imf != null) :

                //Проверка на наличии созданого диалога у получателя, а если есть то просто обновляем кол-во новых сообщений в диалоге
                if ($imf->user_id == $request->for_user_id && $imf->im_user_id == $user->id) :

                    $all_im_num = $imf->all_msg_num + 1;
                    $im_num = $imf->msg_num + 1;
                    $imf->all_msg_num = $all_im_num;
                    $imf->msg_num = $im_num;

                    $imf->save();
                endif;

        else :

            //созданого диалога у получателя
            $imf = new IMVK;

            $imf->user_id = $request->for_user_id;
            $imf->im_user_id = $user->id;
            $imf->all_msg_num = 1;
            $imf->msg_num = 1;

            $imf->save();
            $imf->user()->attach($user->id);


        endif;

        //Отправляем сообщение получателю
        $message = new IMVKMessages;

        $message->text = $request->text;
        $message->for_user_id = $request->for_user_id;
        $message->from_user_id = $user->id;
        $message->pm_read = 'no';
        $message->folder = 'inbox';
        $message->i_m_v_k_id = $imf->id;

        $message->save();

        //Сохраняем сообщение в папку отправленные
        $message_sender = new IMVKMessages;

        $message_sender->text = $request->text;
        $message_sender->for_user_id = $user->id;
        $message_sender->from_user_id = $request->for_user_id;
        $message_sender->pm_read = 'no';
        $message_sender->folder = 'outbox';
        $message_sender->i_m_v_k_id = $im->id;

        $message_sender->save();

        // send notification on pusher.com
         $pusher = new \Pusher(
             config('broadcasting.connections.pusher.key'),
             config('broadcasting.connections.pusher.secret'),
             config('broadcasting.connections.pusher.app_id'),
             config('broadcasting.connections.pusher.options')
         );

         //set message data
         $data = [
             'message' => $message,
             'from_user' => $user,
             'for_user' => $request->for_user
         ];
         $pusher->trigger( ['message'.$request->for_user_id], 'SendIMVKMessage', $data);

//        event(new SendIMVKMessage($message, $user, $request->for_user));

        return redirect()->back();

    }


    //################### Прочтение сообщения ###################//
//    $msg_id = intval($_POST['msg_id']);
//
//    $check = $db->super_query("SELECT from_user_id FROM `im_vk_messages` WHERE id = '".$msg_id."' AND folder = 'inbox' AND pm_read = 'no'");
//
//    if($check){
//        $db->query("UPDATE `im_vk_messages` SET pm_read = 'yes' WHERE id = '".$msg_id."'");
//        $db->query("UPDATE `im_vk_messages` SET pm_read = 'yes' WHERE id = '".($msg_id+1)."'");
//        $db->query("UPDATE `im_vk` SET msg_num = msg_num-1 WHERE user_id = '".$user_id."' AND im_user_id = '".$check['from_user_id']."'");
//
//    }

}