<?php
/**
 * class TimeLogic.php
 */
class TimeLogic
{
    /**
     * CI_Controller格納用
     * @access private
     * @var CI_Controller
     */
    private $CI = null;

    /**
     * デバッグ用に変化させる時刻のキャッシュ
     * @access private
     * @var null|int
     */
    private $application_time_offset = null;

    /**
     * トランザクション時間(TimeLogicがロードされた時間)
     */
    private $transaction_time = null;

    /**
     * 時刻設定の種類
     * @var int
     */
    private $time_type = 0;

    /**
     * 設定されている時間種類を返却
     * @return int 0:通常時間 1:個人デバック時間 2:全体デバック時間
     */
    public function get_time_type()
    {
        return $this->time_type;
    }

    /**
     * 設定されている時間オフセットを返却
     * @return int 差分秒数
     */
    public function get_application_time_offset()
    {
        return $this->application_time_offset;
    }

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->CI = &get_instance();

        $this->set_current_time();
        $this->transaction_time = $this->get_time();
    }

    /**
     * current_timeをセットする
     */
    public function set_current_time()
    {
        return $this->CI->current_time = $this->get_time();
    }

    /**
     * トランザクション時間(TimeLogicがロードされた時間)をUnixエポック(1970年1月1日 00:00:00 GMT)からの通算秒として返す
     * ※1リクエスト中同じ時間を返す
     *
     * @return トランザクション時間
     */
    public function get_transaction_time()
    {
        return $this->transaction_time;
    }

    /**
     * フォーマット文字列によりフォーマットされたトランザクション時間の時刻を返す
     *
     * @param $format 出力される日付文字列の書式
     * @return 日付を表す文字列
     */
    public function get_transaction_date($format)
    {
        return date($format, $this->transaction_time);
    }

    /**
     * 現在時刻(デバッグ用に変更した場合は変更した時刻)をUnixエポック(1970年1月1日 00:00:00 GMT)からの通算秒として返す
     * @access public
     * @return int
     */
    public function get_time()
    {
        return time();
    }

    /**
     * フォーマット文字列によりフォーマットされた時刻を返す
     * @access public
     * @param $format           出力される日付文字列の書式
     * @param null $time_stamp  Unixタイムスタンプ。指定されてない場合は現在時刻のタイムスタンプを使用します。
     * @return bool|string      日付を表す文字列
     */
    public function get_date($format, $time_stamp = null)
    {
        if (is_null($time_stamp)) {
            // タイムスタンプが指定されてない場合は現在時刻を使用する
            $time = $this->get_time();
        } else {
            // タイムスタンプが指定されている場合は指定されたタイムスタンプを使用する
            $time = $time_stamp;
        }
        return date($format, $time);
    }

    /**
     * 期間内かどうか調べる
     *
     * @param start_time 開始日時 datetime型
     * @param add_second 開始日時からの経過秒数
     * @param inspect_unixtime 期間内か調べる日時。主に現在日時などが入る。 unixtime型
     * @return TRUE: 期間内  FALSE: 期間外
     */
    public function is_in_time($start_time, $add_second, $inspect_unixtime)
    {
        $start_unixtime = strtotime($start_time);
        $end_time = strtotime($add_second . 'second', $start_unixtime);

        return ($start_unixtime <= $inspect_unixtime) && ($inspect_unixtime <= $end_time);
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
    public function is_in_time_by_all_time($start_time, $end_time, $inspect_time)
    {
        // 設定されていないものは調査時刻を入れておく
        if (is_null($start_time)) {
            $start_time = $inspect_time;
        }
        if (is_null($end_time)) {
            $end_time = $inspect_time;
        }

        $start_unixtime = strtotime($start_time);
        $end_unixtime = strtotime($end_time);
        $inspect_unixtime = strtotime($inspect_time);

        return ($start_unixtime <= $inspect_unixtime) && ($inspect_unixtime <= $end_unixtime);
    }

    /**
     * 差分時間を取得(分)
     *
     * @param start_time 開始日時 datetime型
     * @param end_time 終了日時 datetime型
     * @return 差分時間(分)
     */
    public function get_diff_minute_time($start_time, $end_time)
    {
        return floor((strtotime($end_time) - strtotime($start_time)) / 60);
    }

    /**
     * 差分時間を取得
     *
     * @param start_time 開始日時 datetime型
     * @param end_time 終了日時 datetime型
     * @return 差分時間(秒)
     */
    public function get_diff_date_time($start_time, $end_time)
    {
        return (strtotime($end_time) - strtotime($start_time));
    }


    /**
     * 同じ月かどうか
     */
    public function is_same_month($target, $current = null)
    {
        if (empty($current)) {
            $CI = &get_instance();
            $current = $CI->current_time;
        }

        if (is_string($current)) {
            $current = strtotime($current);
        }

        if (is_string($target)) {
            $target = strtotime($target);
        }

        $current_month = date("Ym", $current);
        $target_month = date("Ym", $target);

        return $current_month == $target_month;
    }

    /**
     * 日付データをDBの日付書式で返却
     *
     * @param int $year 年
     * @param int $month 月
     * @param int $day 日
     * @param int $hour 時
     * @param int $minute 分
     * @param int $second 秒
     * @return datetime YYYY-mm-dd HH:ii:ss
     */
    public static function format_date($year, $month, $day, $hour = 0, $minute = 0, $second = 0)
    {
        return sprintf('%04d-%02d-%02d %02d:%02d:%02d', $year, $month, $day, $hour, $minute, $second);
    }

    /**
     * 日付の書式配列を取得
     *
     * @return array 日付書式配列
     */
    public static function get_date_format()
    {
        return [
            "Y" => "年",
            "m" => "月",
            "d" => "日",
            "H" => "時",
            "i" => "分"
        ];
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
    public function is_past_time($year, $month = 1, $day = 1, $hour = 0, $minute = 0, $second = 0)
    {
        //年月日時分秒が正当かどうか
        if (!checkdate($month, $day, $year) || !is_numeric($hour) || !is_numeric($minute) || !is_numeric($second) ) {
            throw new Exception(__CLASS__ . ':行数:' . __LINE__ . ' 指定の時間が不正です', $this->CI->action_error_code);
        }

        //入力値の年月日時分秒をtimestamp化
        $target_time = mktime($hour, $minute, $second, $month, $day, $year);

        // 未来の日付
        if ($this->CI->current_time < $target_time) {
            return false;
        }

        return true;
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
    public function calcurate_age($year, $month = 1, $day = 1, $hour = 0, $minute = 0, $second = 0)
    {
        $age = 0;

        //年から年齢を取得
        $current_year = (int) date('Y', $this->CI->current_time);
        $calc_result = $current_year - $year;

        //今年の誕生日を取得
        $birth_date_time = mktime($hour, $minute, $second, $month, $day, $current_year);

        //今月の月初日を取得
        $current_month_and_day = strtotime('first day of' , strtotime(get_date('Y-m-d' ,$this->CI->current_time)));

        //その年の誕生日をまだ迎えていない場合は減算（誕生月日の当月、当日はまだ誕生日を向かえていないものとする）
        if ($current_month_and_day <= $birth_date_time) {
            --$calc_result;
        }

        $age = $calc_result;

        return $age;
    }

    /**
     * 曜日名取得
     *
     * @param int date_time 指定日時 unixtime型
     * @return string 曜日名
     */
    public function get_day_of_week($date_time)
    {
        $day_of_week_list = [
            0 => '日',
            1 => '月',
            2 => '火',
            3 => '水',
            4 => '木',
            5 => '金',
            6 => '土'
        ];

        $day_of_week = $day_of_week_list[date('w', $date_time)];
        return $day_of_week;
    }

}
