<?php
//$eg = '01 05 07 22 26 32 11';
//���ݵ�ַ·�� the data path
$file = dirname(__FILE__).'/../data/2003-2015.csv';
$file_out = dirname(__FILE__).'/../data/all_hitory_hit'.date("ymd").'.txt';
//��ȡ���� get the data
$source_data = file_get_contents($file);
$source_data_arr = explode("\n", $source_data);
$source_data_arr_filter = array_filter($source_data_arr);
$put_out_data = '';
foreach($source_data_arr_filter as $each_source_data){
	preg_match("/\"([^\"]*)\"/", $each_source_data, $matches);
	$each_data_arr = explode("|", $matches[1]);
	$data = explode(",", $each_data_arr[0]);
	array_push($data, $each_data_arr[1]);
	$eg = implode(" ", $data);
	$put_out_data .= $each_source_data." ".handle_data($source_data_arr_filter, $eg)."\n";
}
file_put_contents($file_out, $put_out_data);
//print_r(handle_data($source_data_arr_filter, "01 05 07 22 26 32 11"));
function handle_data($source_data_arr_filter, $eg, $flag=true){
	$result = '';
	//��ʼ��һ�Ƚ�����
	$first_prize = 0;
	$first_prize_str = "";
	//��ʼ�����Ƚ�����
	$second_prize = 0;
	$second_prize_str = "";
	//��ʼ�����Ƚ�����
	$third_prize = 0;
	$third_prize_str = "";
	//��ʼ���ĵȽ�����
	$fourth_prize = 0;
	$fourth_prize_str = "";
	//��ʼ����Ƚ�����
	$fifth_prize = 0;
	$fifth_prize_str = "";
	//��ʼ�����Ƚ�����
	$sixth_prize = 0;
	$sixth_prize_str = "";

	foreach($source_data_arr_filter as $each_source_data){
		preg_match("/\"([^\"]*)\"/", $each_source_data, $matches);
		$each_date_arr = explode("|", $matches[1]);
		$data = explode(",", $each_date_arr[0]);
		//�ָ���������
		$eg_arr = explode(" ", $eg);
		//�ָ�ÿ������
		$each_arr = explode(",", $each_date_arr[0]);
		//��ʼ��������������֪����ǰ�����еĳ��ִ���
		$n = 0;
		//��ʼ�����������е��߸����ֳ��ֵĴ���
		$m = 0;
		//ѭ����ʼ
		for($i = 0; $i < 7; ++$i){
			//�ж�ǰ��λ���Ƿ���֣�����¼�����ִ�����
			if($i < 6){
				if(in_array($eg_arr[$i], $each_arr)){
					$n++;
				}
			}else{
				if($each_date_arr[1] == $eg_arr[$i]){
					$m++;
				}
			}
		}
		//һ�Ƚ� 6+1
		if($n == 6 && $m == 1){
			$first_prize++;
			$first_prize_str .= $each_source_data;
		}
		//���Ƚ� 6+0
		if($n == 6 && $m == 0){
			$second_prize++;
			$second_prize_str .= $each_source_data;
		}
		//���Ƚ� 5+1
		if($n == 5 && $m == 1){
			$third_prize++;
			$third_prize_str .= $each_source_data;
		}
		//�ĵȽ� 5+0/4+1
		if($n == 5 && $m == 0 || $n == 4 && $m == 1){
			$fourth_prize++;
			$fourth_prize_str .= $each_source_data;
		}
		//��Ƚ� 4+0/3+1
		if($n == 4 && $m == 0 || $n == 3 && $m == 1){
			$fifth_prize++;
			$fifth_prize_str .= $each_source_data;
		}
		//���Ƚ� 2+1/1+1/0+1
		if($n == 2 && $m == 1 || $n == 1 && $m == 1 || $n == 0 && $m == 1){
			$sixth_prize++;
			$sixth_prize_str .= $each_source_data;
		}
	}
	if($flag){
		$result = 'һ�Ƚ� '.$first_prize.' �Σ����Ƚ� '.$second_prize.' �Σ����Ƚ� '.$third_prize.' �Σ��ĵȽ� '.$fourth_prize.' �Σ���Ƚ� '.$fifth_prize.' ��;���Ƚ� '.$sixth_prize.' �Ρ�';
	}else{
		$result = 'һ�Ƚ� '.$first_prize.' �Σ�
����Ϊ
'.$first_prize_str.';
���Ƚ� '.$second_prize.' �Σ�
����Ϊ
'.$second_prize_str.';
���Ƚ� '.$third_prize.' �Σ�
����Ϊ
'.$third_prize_str.';
�ĵȽ� '.$fourth_prize.' �Σ�
����Ϊ
'.$fourth_prize_str.';
��Ƚ� '.$fifth_prize.' ��;
����Ϊ
'.$fifth_prize_str.';
���Ƚ� '.$sixth_prize.' ��;
����Ϊ
'.$sixth_prize_str.'��';
	}
	return $result;
}
?>