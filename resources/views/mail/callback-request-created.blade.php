<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Новая заявка с сайта</title>
</head>
<body style="margin:0;padding:0;background:#eef4ee;font-family:Arial,Helvetica,sans-serif;color:#253024;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#eef4ee;padding:28px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:640px;background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #d9e4d8;">
                    <tr>
                        <td style="background:#547b53;padding:26px 30px;color:#ffffff;">
                            <div style="font-size:14px;line-height:1.4;opacity:.86;">{{ $siteName }}</div>
                            <h1 style="margin:8px 0 0;font-size:28px;line-height:1.2;font-weight:700;">Новая заявка с сайта</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px;">
                            <p style="margin:0 0 22px;font-size:16px;line-height:1.55;color:#5b5e61;">
                                Посетитель оставил заявку. Свяжитесь с ним, чтобы уточнить детали.
                            </p>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:separate;border-spacing:0 10px;">
                                <tr>
                                    <td style="width:160px;padding:14px 16px;background:#f7faf7;border-radius:8px 0 0 8px;color:#5b5e61;font-size:14px;">Имя</td>
                                    <td style="padding:14px 16px;background:#f7faf7;border-radius:0 8px 8px 0;font-size:16px;font-weight:700;">
                                        {{ $callbackRequest->getAttribute('name') ?: 'Не указано' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:160px;padding:14px 16px;background:#f7faf7;border-radius:8px 0 0 8px;color:#5b5e61;font-size:14px;">Телефон</td>
                                    <td style="padding:14px 16px;background:#f7faf7;border-radius:0 8px 8px 0;font-size:16px;font-weight:700;">
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $callbackRequest->getAttribute('phone')) }}" style="color:#253024;text-decoration:none;">{{ $callbackRequest->getAttribute('phone') }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:160px;padding:14px 16px;background:#f7faf7;border-radius:8px 0 0 8px;color:#5b5e61;font-size:14px;">Статус</td>
                                    <td style="padding:14px 16px;background:#f7faf7;border-radius:0 8px 8px 0;font-size:16px;">
                                        {{ $callbackRequest->status->label() }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:160px;padding:14px 16px;background:#f7faf7;border-radius:8px 0 0 8px;color:#5b5e61;font-size:14px;">Дата</td>
                                    <td style="padding:14px 16px;background:#f7faf7;border-radius:0 8px 8px 0;font-size:16px;">
                                        {{ $callbackRequest->created_at?->format('d.m.Y H:i') }}
                                    </td>
                                </tr>
                                @if($callbackRequest->getAttribute('page_url'))
                                    <tr>
                                        <td style="width:160px;padding:14px 16px;background:#f7faf7;border-radius:8px 0 0 8px;color:#5b5e61;font-size:14px;">Страница</td>
                                        <td style="padding:14px 16px;background:#f7faf7;border-radius:0 8px 8px 0;font-size:16px;">
                                            <a href="{{ $callbackRequest->getAttribute('page_url') }}" style="color:#547b53;text-decoration:underline;">{{ $callbackRequest->getAttribute('page_url') }}</a>
                                        </td>
                                    </tr>
                                @endif
                            </table>

                            <div style="margin-top:18px;padding:18px 20px;border-left:4px solid #547b53;background:#f7faf7;border-radius:8px;">
                                <div style="margin-bottom:8px;color:#5b5e61;font-size:14px;">Комментарий</div>
                                <div style="font-size:16px;line-height:1.55;white-space:pre-line;">{{ $callbackRequest->getAttribute('comment') ?: 'Без комментария' }}</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 30px;background:#f7faf7;color:#7b857a;font-size:13px;line-height:1.5;">
                            Это автоматическое письмо с сайта {{ $siteUrl }}.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
