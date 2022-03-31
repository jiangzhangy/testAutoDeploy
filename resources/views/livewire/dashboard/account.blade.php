<div class="flex flex-col mt-10 ml-10">

   <div class="w-[800px] h-[254px] border border-[#E1E3E6]">
      <div class="flex flex-row justify-between items-center m-10">
         <div class="flex items-center" x-data="{

         }">
            <div class="h-[100px] w-[100px] cursor-pointer relative "
                 @mouseover="$refs.editAvatar.style.display = 'block'"
                 @mouseleave="$refs.editAvatar.style.display = 'none'"
            >
               {{--<img class="h-25 w-25" src="{{ $userInfo['localheadurl'] ?? asset('images/backend/icon_Defaultavatar_100.png') }}" alt="avatar">--}}
               <div class="h-24 w-24 rounded-full bg-center bg-[length:auto_100%] bg-no-repeat" style="background-image: url({{ $userInfo['localheadurl'] ?? asset('images/backend/icon_Defaultavatar_100.png') }})"></div>
               <div x-ref="editAvatar" class="absolute h-[100px] w-[100px] bg-[#03080F] opacity-50 border rounded-full text-center text-white leading-[100px] -top-[2px] -left-[2px] hidden" @click="changShowLayer('showEditAvatar')">修改</div>
            </div>
            <div class="ml-[30px]">
               <h2 class="text-lg font-bold text-[#202123]">{{ $userInfo['nickname'] }}
                  <span class="h-[30px] w-[30px] hover:bg-[#D2E3FC] rounded-full cursor-pointer" @click="changShowLayer('showEditName')"><img class="inline w-[25px]" src="{{ asset('images/backend/icon_edit_normal.png') }}" alt=""></span>
               </h2>
               <p class="text-sm text-[#64666B] mt-6">{{ substr($userInfo['account'], 0, 2) . '*****' . substr($userInfo['account'], -4)}}
                  <span class="h-[30px] w-[30px] hover:bg-[#D2E3FC] rounded-full cursor-pointer" @click="changShowLayer('showEditPhone')"><img class="inline w-[25px]" src="{{ asset('images/backend/icon_edit_normal.png') }}" alt=""></span></p>
            </div>
         </div>
         <span class="text-sm text-[#ACAFB5]">已使用傲梅服务 {{ now()->diffInDays(\Carbon\Carbon::createFromTimeStamp($userInfo['creattime'] / 1000)->toDateTimeString()) }} 天</span>
      </div>
      @if($userInfo['wxdetails'] === null)
         <div class="w-[218px] h-[34px] m-10  border border-[#ACAFB5] flex justify-center items-center cursor-pointer" @click="changShowLayer('showBoundWechat')">
            <img class="h-[19px]" src="{{ asset('images/backend/icon_bt_wechatbind_normal.png') }}" alt="">
            <p class="text-[#64666B] text-sm ml-2">绑定微信，扫码登录更方便</p>
         </div>
      @else
         <div class="w-[218px] h-[34px] -ml-3 flex justify-center items-center">
            <img class="h-[19px]" src="{{ asset('images/backend/icon_bt_wechatbind_normal.png') }}" alt="wx">
            <p class="text-[#64666B] text-sm ml-2">已绑定微信</p>
         </div>
      @endif
   </div>

   <div class="mt-11">
      <img src="{{ asset('images/backend/icon_Diamond.png') }}" alt="特权" class="m-2 inline"><span>我的特权</span>
      @if($userInfo['productdetails'] !== null)
         <div class="mt-6 w-80 h-[162px] bg-none border rounded-md px-[15px] pt-[20px]" style="background-image: url({{ asset('images/backend/img_card_vip.png') }})">
            <h3 class="text-[#0B3769] text-sm font-bold">傲梅轻松备份</h3>
            <p class="text-xs text-white mt-6">使用期限:终身使用</p>
            <p class="text-xs text-white mt-3">使用须知：仅用于显示当前用户为该软件会员用户，不支持其他用途。</p>
            <span class="text-xs text-[#A0C6F0] ml-[170px]">
            尊贵特权<img class="inline" src="{{ asset('images/backend/icon_card_Diamond.png') }}" alt="vip">会员专享
         </span>
         </div>
      @endif
   </div>

</div>
