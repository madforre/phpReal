<?php

class Request
{
    function __construct()
    {
        // 생성자와 동시에 실행되는 메서드 bootstrapSelf(), toCamelCase()
        $this->bootstrapSelf();
    }
    
    private function bootstrapSelf()
    {
        // 슈퍼 변수인 서버를 풀어서 캐멀케이스로 변환 후 클래스의 프로퍼티에 전부 저장
        foreach ($_SERVER as $key => $value) {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    private function toCamelCase($string)
    {
        // 전달받은 슈퍼 변수 서버 키를 소문자로 변경
        $result = strtolower($string);

        // 정규 표현식 snake_case 필터링
        preg_match_all('/_[a-z]/', $result, $matches);
        
        // camelCase로 가공한 다음 snake_case에 덮어쓰기
        foreach ($matches[0] as $match)
        {
            $c = str_replace('_','',strtoupper($match));
            $result = str_replace($match, $c, $result);
        }
        // bootstrapSelf() 메소드에 값을 반환
        return $result;
    }
}

