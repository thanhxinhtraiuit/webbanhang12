<?php
use App\Http\Controllers\BotManController;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\Drivers\Facebook\Extensions;
use BotMan\BotMan\Interfaces\WebAccess;
use BotMan\Drivers\Facebook\Extensions\ListTemplate;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\Drivers\Facebook\Extensions\Element;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;
use BotMan\Drivers\Facebook\Extensions\GenericTemplate;
use App\Sanpham;
use App\Danhmuc;


$danhmuc=Danhmuc::all();
$botman = resolve('botman');
//----macdinh
$botman->hears('ho tro', function ($bot) {
    $bot->reply('Chào mừng bạn đến với cuteshop, để được hỗ chợ vui lòng nhập : cuteshop');
});$botman->hears('Chao shop', function ($bot) {
    $bot->reply('Chào mừng bạn đến với cuteshop, để được hỗ chợ vui lòng nhập : cuteshop');
});
$botman->hears('ad', function ($bot) {
    $bot->reply('Chào mừng bạn đến với cuteshop, để được hỗ chợ vui lòng nhập : cuteshop');
});
$botman->hears('hello', function ($bot) {
    $bot->reply('Chào mừng bạn đến với cuteshop, để được hỗ chợ vui lòng nhập : cuteshop');
});
$botman->hears('Hi', function ($bot) {
    $bot->reply('Chào mừng bạn đến với cuteshop, để được hỗ chợ vui lòng nhập : cuteshop');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');

//---------------------------


$botman->hears('cuteshop', function ($bot) {
    $bot->reply(Question::create('Bạn muốn hỗ trợ theo cách nào :')->addButtons([
    	Button::create('BotChat (Now)')->value('bot'),
    	Button::create('NV hỗ trợ(Late)')->value('sm')
    ]));
	});
//lua chon SM
$botman->hears('sm', function ($bot) {
		$bot->reply('Nhân viên chăm sóc khách hàng đang đi giải cứu thế giới, bạn vui lòng đợi .Nếu muốn lựa chọn lại, vui lòng nhập : cuteshop');
});


// lua chon botchat
$botman->hears('bot', function ($bot) {
		$bot->reply(Question::create('Bạn cần hỗ trợ về:')->addButtons([
    	Button::create('Tìm kiếm sản phẩm')->value('timkiem'),
    	Button::create('Thông tin cửa hàng')->value('thongtin')
    	

    ]));
});
$botman->hears('thongtin', function ($bot) {
    $bot->reply('Cuteshop chuyên cung cấp các loại phụ kiện , thời trang cho các bạn nữ.');
    $bot->reply('Địa chỉ : Linh Trung /Thủ Đức /tp hồ Chí Minh  ');
    $bot->reply('Số điện thoại : 0568877844');
    $bot->reply('Để quay lại vui lòng nhập : bot');
    
});
//lua chon botchat -> tim kiem
$arr=[];
foreach ($danhmuc as $value) {
	$arr[]=Button::create($value->ten_danh_muc)->value("timkiemsp/".$value->id);
}
//danh muc san pham
$botman->hears('timkiem', function ($bot) use ($arr) {
		
		$bot->reply(Question::create('Bạn cần tìm sản phẩm trong :')->addButtons($arr));
});
//goi y san pham trong danh muc

$botman->hears('timkiemsp/{id}', function ($bot,$id)  {
		$sanpham=Sanpham::where('id_danh_muc',$id)->take(3)->get();
		foreach ($sanpham as $value) {
		

		$abc[]=Element::create($value->ten_san_pham)
	            ->subtitle($value->mo_ta)
	            ->image('http://test.wikivps.com/upload/'.$value->hinh)
	            ->addButton(ElementButton::create('Xem Chi Tiet')
	                ->url('http://test.wikivps.com/chi-tiet-san-pham/'.$value->id.'/'.$value->ten_khong_dau)
	            );
		}

		$bot->reply(GenericTemplate::create()
	    ->addImageAspectRatio(GenericTemplate::RATIO_SQUARE)
	    ->addElements($abc)
		);


		// $bot->reply(Question::create('Một số sản phẩm của shop :')->addButtons($arr));
    
});
// $botman->hears('sanpham/{id}', function ($bot,$id)  {
// 	$sanpham=Sanpham::find($id);
// 	$bot->reply(GenericTemplate::create()
// 	    ->addImageAspectRatio(GenericTemplate::RATIO_SQUARE)
// 	    ->addElements([
// 	        Element::create($sanpham->ten_san_pham)
// 	            ->subtitle($sanpham->mo_ta)
// 	            ->image('http://botman.io/img/botman-body.png')
// 	            ->addButton(ElementButton::create('Xem Chi Tiet')
// 	                ->url('https://39e8f152.ngrok.io/botman/tinker')
// 	            )
	            
// 	    ])
// 	);
// });