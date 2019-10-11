<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_excel {
	
	public $filename 		= 'export-callreport';
	public $custom_titles;
	
    public function make_from_array($titles, $array) {
		$data = NULL;

		if (!is_array($array)) {
			show_error('The data supplied is not a valid array');
		}
		else {
			$headers = $this->titles($titles);

			if (is_array($array)) {
				foreach ($array AS $row) {
					$line = '';
					foreach ($row AS $value) {
						if (!isset($value) OR $value == '') {
							$value = "\t";
						}
						else {
							$value = str_replace('"', '""', $value);
							$value = '"' . $value . '"' . "\t";
						}
						$line .= $value;
					}
					$data .= iconv( "UTF-8", "GB18030//IGNORE", trim($line)) . "\n";
				}
				$data = str_replace("\r", "", $data);

				$this->generate($headers, $data);
			}
		}
	}

	private function generate($headers, $data) {
		$this->set_headers();

		echo "$headers\n$data";
	}

	public function titles($titles) {
		if (is_array($titles)) {
			$headers = array();

			if (is_null($this->custom_titles)) {
				if (is_array($titles)) {
					foreach ($titles AS $title) {
						$headers[] = iconv( "UTF-8", "GB18030//IGNORE", $title);
					}
				}
				else {
					foreach ($titles AS $title) {
						$headers[] = iconv( "UTF-8", "GB18030//IGNORE", $title->name);
					}
				}
			}
			else {
				$keys = array();
				foreach ($titles AS $title) {
					$keys[] = iconv( "UTF-8", "GB18030//IGNORE", $title->name);
				}
				foreach ($keys AS $key) {
					$headers[] = iconv( "UTF-8", "GB18030//IGNORE", $this->custom_titles[array_search($key, $keys)]);
				}
			}

			return implode("\t", $headers);
		}
	}

	private function set_headers() {
		$ua = $_SERVER["HTTP_USER_AGENT"];
		$filename = $this->filename . ".xls";
		$encoded_filename = urlencode($filename);
		$encoded_filename = str_replace("+", "%20", $encoded_filename);		
		//ob_end_clean(); 
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		//header("Content-Type: application/vnd.ms-excel;charset=UTF-8");
		header("Content-Type: application/download");;
		if (preg_match("/MSIE/", $ua)) {  
			header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
		} else if (preg_match("/Firefox/", $ua)) {  
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
		} else {  
			header('Content-Disposition: attachment; filename="' . $filename . '"');
		}
		header("Content-Transfer-Encoding: binary ");
	}
	
	public function exports_csv($titles, $array, $filename)
	{
		$data[] = array();
		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=\"".$filename."\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		$handle = fopen('php://output', 'w');
		fputcsv($handle, $titles);
		foreach ($array as $data) {
			fputcsv($handle, $data);
		}
		fclose($handle);
	}
	
	public function all_exports_csv($array, $filename)
	{
		$data[] = array('x'=> $x, 'y'=> $y, 'z'=> $z, 'a'=> $a);
		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=\"".$filename."\"");
		header("Pragma: no-cache");
		header("Expires: 0");

		$handle = fopen('php://output', 'w');

		foreach ($array as $data) {
			fputcsv($handle, $data);
		}
		fclose($handle);
	}
}
?>