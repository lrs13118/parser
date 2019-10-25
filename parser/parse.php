<?php 
	require 'phpQuery.php';
	include 'db-connect.php';

	header ('Content-type: text/html; charset=utf-8');

	$dbCleanUp = "DELETE FROM `matches`";
	$CleanUpResult = mysqli_query ($connection, $dbCleanUp) or die ("Ошибка " . mysqli_error($connection));

	$url = 'https://www.marathonbet.ru/su/popular/Football';
	$file = file_get_contents($url);
	$doc = phpQuery::newDocument($file); 

	foreach ($doc->find('.category-container') as $article) {
		$article = pq($article); 
		$title = strip_tags($article->find('.category-label-link')->html());
		$href = $article->find('.category-label-link')->attr('href');

		$urlContent = "https://www.marathonbet.ru" . $href;
		$fileContent = file_get_contents($urlContent);
		$docContent = phpQuery::newDocument($fileContent);
		$content = $docContent->find('.category-container')->html();
		$content = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $content);
		$content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $content);

		$query = "INSERT INTO `matches` (`title`, `href`, `content`) VALUES ('".$title."', '".$href."', '".$content."')";
		$result = mysqli_query ($connection, $query) or die ("Ошибка " . mysqli_error($connection));
	}

	for ($page = 3; $page <= 10; $page++) {
		$url = 'https://www.marathonbet.ru/su/popular/Football?cpcids=7560881&page='.$page.'&pageAction=getPage&_='.time();
		$file = file_get_contents($url);
		$file_dec = json_decode($file, true);
		$doc = phpQuery::newDocument($file_dec[0]['content']);

		if ($doc->find('.category-container')->count()) {
			foreach ($doc->find('.category-label-link') as $item) {
				$item = pq($item);
				$url = $item->attr('href');
				$name = "";
				foreach ($item->find('.nowrap') as $n) {
					$n = pq($n);
					$name .= $n->text();
				}
			$urlJ = "https://www.marathonbet.ru" . $url;
			$fileJ = file_get_contents($urlJ);
			$docJ = phpQuery::newDocument($fileJ);
			$contentJ = $docJ->find('.category-container')->html();
			$contentJ = preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $contentJ);
			$contentJ = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $contentJ);

			$queryJ = "INSERT INTO `matches` (`title`, `href`, `content`) VALUES ('".$name."', '".$urlJ."', '".$contentJ."')";
			$resultJ = mysqli_query ($connection, $queryJ) or die ("Ошибка " . mysqli_error($connection));
			}
		} else {break;}
	}

?>

