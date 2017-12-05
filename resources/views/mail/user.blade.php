@component('mail::message')
# 尊敬的 {{ $email }}

您的验证码为:

@component('mail::panel')
    <b style="color: black">{{ $code }}</b>
@endcomponent

## 注意：
请在15分钟内使用当前验证码，过期将作废!<br>
@endcomponent
