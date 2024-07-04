
<div style="border: 2px solid rgb(158, 178, 240);padding: 15px;background:rgb(218, 225, 246);width: 600px; margin: auto;">
    <h3>Hi {{ $customer->name }}</h3>
    <p>Bạn muốn lấy lại mật khẩu.</p>
    <p>
        <a href="{{ route('password.reset',$token) }}" style="display: inline-block;padding: 7px 25px; color: white;background-color: rgb(155, 190, 251);">Click here to get new password</a>
    </p>
</div>

