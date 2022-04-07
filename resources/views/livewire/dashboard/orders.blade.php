<div class="ml-10 mt-10">
    <table class="w-[1200px] text-sm">
        <thead class="text-white h-10">
        <tr class="bg-[#A2A9B0]">
            <th class="rounded-l">付费时间</th>
            <th class="">订单号</th>
            <th class="">购买产品</th>
            <th class="">版本</th>
            <th class="">支持设备数</th>
            <th class="">有效期</th>
            <th class="">订单金额</th>
            <th class="rounded-r">状态</th>
        </tr>
        </thead >
        <tbody>
        @foreach( $orders as $key => $order )
            @if(!\Illuminate\Support\Str::startsWith($order['paymentDetails']['orderId'], 'ABB'))
            <tr class="hover:bg-[#D6E7FF] border border-x-0 border-t-0 border-b text-[#64666B] text-center h-[61px]">
                <td class="">{{ date('Y年m月d日', $order['paymentDetails']['createTime']/1000) }}</td>
                <td class="">{{ $order['paymentDetails']['orderId'] }}</td>
                <td class="">{{ $order['type'] === 'AB' ? '傲梅轻松备份' : '其他' }}</td>
                <td class="">{{ $order['proVersion'] === "47" ? '终身版' : '其他' }}</td>
                <td class="">{{ $order['paymentDetails']['devices'] }}</td>
                <td class="">{{ $order['paymentDetails']['eTime'] === "0" ? '终身' : date('Y年m月d日', $order['paymentDetails']['eTime']/1000) }}</td>
                <td class="">98元</td>
                <td class="">正常</td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
</div>
