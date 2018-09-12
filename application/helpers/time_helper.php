<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * time_helper.php
 */


/**
 * トランザクション時間(TimeLogicがロードされた時間)をUnixエポック(1970年1月1日 00:00:00 GMT)からの通算秒として返す
 * ※1リクエスト中同じ時間を返す
 *
 * @return トランザクション時間
 */
if (!function_exists('get_transaction_time')) {
    function get_transaction_time()
    {
        $CI = &get_instance();
        return $CI->timelogic->get_transaction_time();
    }
}

/**
 * フォーマット文字列によりフォーマットされたトランザクション時間の時刻を返す
 *
 * @param $format 出力される日付文字列の書式
 * @return 日付を表す文字列
 */
if (!function_exists('get_transaction_date')) {
    function get_transaction_date($format)
    {
        $CI = &get_instance();
        return $CI->timelogic->get_transaction_date($format);
    }
}

/**
 * 現在時刻(デバッグ用に変更した場合は変更した時刻)をUnixエポック(1970年1月1日 00:00:00 GMT)からの通算秒として返す
 * @return int
 */
if (!function_exists('get_time')) {
    function get_time()
    {
        $CI = &get_instance();
        return $CI->timelogic->get_time();
    }
}

/**
 * フォーマット文字列によりフォーマットされた時刻を返す
 * @param $format           出力される日付文字列の書式
 * @param null $time_stamp  Unixタイムスタンプ。指定されてない場合は現在時刻のタイムスタンプを使用します。
 * @return bool|string      日付を表す文字列
 */
if (!function_exists('get_date')) {
    function get_date($format, $time_stamp = null)
    {
        $CI = &get_instance();
        return $CI->timelogic->get_date($format, $time_stamp);
    }
}

/**
 * 期間内かどうか調べる
 *
 * @param start_time 開始日時 datetime型
 * @param add_second 開始日時からの経過秒数
 * @param inspect_unixtime 期間内か調べる日時。主に現在日時などが入る。 unixtime型
 * @return TRUE: 期間内  FALSE: 期間外
 */
if (!function_exists('is_in_time')) {
    function is_in_time($start_time, $add_second, $inspect_unixtime)
    {
        $CI = &get_instance();
        return $CI->timelogic->is_in_time($start_time, $add_second, $inspect_unixtime);
    }
}

/**
 * 期間内かどうか調べる(全てtime型)
 *  ※time型は以下を参照 http://jp2.php.net/manual/ja/datetime.formats.time.php
 *
 * @param start_time 開始日時 time型
 * @param end_time 終了日時 time型
 * @param inspect_time 期間内か調べる日時。主に現在日時などが入る。 time型
 * @return TRUE: 期間内  FALSE: 期間外
 */
if (!function_exists('is_in_time_by_all_time')) {
    function is_in_time_by_all_time($start_time, $end_time, $inspect_time)
    {
        $CI = &get_instance();
        return $CI->timelogic->is_in_time_by_all_time($start_time, $end_time, $inspect_time);
    }
}

/**
 * 差分時間を取得(分)
 *
 * @param start_time 開始日時 datetime型
 * @param end_time 終了日時 datetime型
 * @return 差分時間(分)
 */
if (!function_exists('get_diff_minute_time')) {
    function get_diff_minute_time($start_time, $end_time)
    {
        $CI = &get_instance();
        return $CI->timelogic->get_diff_minute_time($start_time, $end_time);
    }
}

/**
 * 差分時間を取得
 *
 * @param start_time 開始日時 datetime型
 * @param end_time 終了日時 datetime型
 * @return 差分時間(秒)
 */
if (!function_exists('get_diff_date_time')) {
    function get_diff_date_time($start_time, $end_time)
    {
        $CI = &get_instance();
        return $CI->timelogic->get_diff_date_time($start_time, $end_time);
    }
}

/**
 * 同じ月かどうか
 *
 * @dataProvider is_same_month_data
 */
if (!function_exists("is_same_month")) {
    function is_same_month($target, $current = null)
    {
        $CI = &get_instance();
        return $CI->timelogic->is_same_month($target, $current);
    }
}

/**
 * 日付データをDBの日付書式で返却
 *
 * @dataProvider data_for_format_date
 */
if (!function_exists("format_date")) {
    function format_date($year, $month, $day, $hour = 0, $minute = 0, $second = 0)
    {
        $CI = &get_instance();
        return $CI->timelogic->format_date($year, $month, $day, $hour, $minute, $second);
    }
}

/**
 * 日付の書式配列を取得
 *
 * @dataProvider data_for_get_date_format
 */
if (!function_exists("get_date_format")) {
    function get_date_format()
    {
        $CI = &get_instance();
        return $CI->timelogic->get_date_format();
    }
}


/**
 * 過去時間かどうかをチェック
 *
 * @param int year 年
 * @param int month 月（指定がなければ1月を指定）
 * @param int day 日（指定がなければ1日を指定）
 * @param int hour 時間（指定がなければ0時を指定）
 * @param int minute 分（指定がなければ0分を指定）
 * @param int second 秒（指定がなければ0秒を指定）
 *
 * @return bool 過去の日付であればtrue
 */
if (!function_exists('is_past_time')) {
    function is_past_time($year, $month = 1, $day = 1, $hour = 0, $minute = 0, $second = 0)
    {
        $CI = &get_instance();
        return $CI->timelogic->is_past_time($year, $month, $day, $hour, $minute, $second);
    }
}

/**
 * 年齢計算
 *
 * @param int year 年
 * @param int month 月（指定がなければ1月を指定）
 * @param int day 日（指定がなければ1日を指定）
 * @param int hour 時間（指定がなければ0時を指定）
 * @param int month 分（指定がなければ0分を指定）
 * @param int second 秒（指定がなければ0秒を指定）
 *
 * @return int 年齢
 */
if (!function_exists('calcurate_age')) {
    function calcurate_age($year, $month = 1, $day = 1, $hour = 0, $minute = 0, $second = 0)
    {
        $CI = &get_instance();
        return $CI->timelogic->calcurate_age($year, $month, $day, $hour, $minute, $second);
    }
}


/**
 * 曜日名取得
 *
 * @param  int    date_time 指定日時 unixtime型
 * @return string 曜日名
 */
if (!function_exists('get_day_of_week')) {
    function get_day_of_week($date_time)
    {
        $CI = &get_instance();
        return $CI->timelogic->get_day_of_week($date_time);
    }
}
