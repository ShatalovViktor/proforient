<?php
$coord=(string)$_POST['message'];
$params = array(
    'geocode' => $coord , 							// ����������
    'format'  => 'json',                          // ������ ������
    'results' => 1,                               // ���������� ��������� �����������
    'key'     => 'AGybdlIBAAAADzcrAQQA5gedE7XoT9UWKazFFgQVQWF485cAAAAAAAAAAAD3euohBHdP7SVNBMlxPK205sLnrg==',                           // ��� api key
);
$response = json_decode(file_get_contents('http://geocode-maps.yandex.ru/1.x/?' . http_build_query($params, '', '&')));
 
if ($response->response->GeoObjectCollection->metaDataProperty->GeocoderResponseMetaData->found > 0)
{
    echo $response->response->GeoObjectCollection->featureMember[0]->GeoObject->metaDataProperty->GeocoderMetaData->AddressDetails->Country->AddressLine;
}
else
{
    echo '������ �� �������';
} 