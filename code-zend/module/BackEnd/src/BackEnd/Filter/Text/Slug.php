<?php

namespace BackEnd\Filter\Text;

use Zend\Filter\Word\CamelCaseToUnderscore;
use Zend\Filter\AbstractFilter;
use Zend\Filter\Word\AbstractSeparator;

class Slug extends AbstractSeparator {

    public function __construct($separator = '-') {
        parent::__construct($separator);
    }

    public function filter($value) {
        $value = trim($value);
        if (!$value) {
            return;
        }
        $value = str_replace(array('Â', 'Ấ', 'Ầ', 'Ẫ', 'Ậ', 'Ẩ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'Ă', 'Ắ', 'Ằ', 'Ẵ', 'Ẳ', 'Ặ', 'ă', 'ắ', 'ằ', 'ẳ', 'ặ', 'ẵ', 'á', 'à', 'ả', 'ã', 'ạ', 'Á', 'À', 'Ả', 'Ã', 'Ạ'), 'a', $value);
        $value = str_replace(array('Ê', 'Ế', 'Ề', 'Ễ', 'Ệ', 'Ể', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'é', 'è', 'ẻ', 'ẹ', 'ẽ', 'É', 'È', 'Ẻ', 'Ẹ', 'Ẽ'), 'e', $value);
        $value = str_replace(array('Í', 'Ì', 'Ĩ', 'Ị', 'Ỉ', 'í', 'ì', 'ĩ', 'ỉ', 'ị'), 'i', $value);
        $value = str_replace(array('Ý', 'Ỳ', 'Ỹ', 'Ỵ', 'Ỷ', 'ý', 'ỳ', 'ỹ', 'ỷ', 'ỵ'), 'y', $value);
        $value = str_replace(array('Đ', 'đ'), 'd', $value);
        $value = str_replace(array('Ô', 'Ố', 'Ỗ', 'Ộ', 'Ồ', 'Ổ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'ơ', 'ớ', 'ờ', 'ỡ', 'ở', 'ợ', 'Ó', 'Ò', 'Ỏ', 'Ọ', 'Õ', 'ó', 'ò', 'ỏ', 'ọ', 'õ'), 'o', $value);
        $value = str_replace(array('Ư', 'Ứ', 'Ừ', 'Ự', 'Ử', 'Ự', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'Ù', 'Ú', 'Ũ', 'Ụ', 'Ủ', 'ú', 'ù', 'ủ', 'ũ', 'ụ'), 'u', $value);
        $value = str_replace(array('Ù', 'Ú', 'Ũ', 'Ụ', 'Ủ', 'ú', 'ù', 'ủ', 'ũ', 'ụ'), 'u', $value);
        $value = preg_replace('/[^a-zA-Z0-9\s]/i', ' ', $value);
        $value = str_replace('_', ' ', $value);
        $value = str_replace(array('    ', '   ', '  '), ' ', $value);
        if ($this->separator != ' ') {
            $value = str_replace(' ', $this->separator, trim($value));
        }
        $value = strtolower($value);

        return $value;
    }

}
