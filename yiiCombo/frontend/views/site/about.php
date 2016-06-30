<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- This is the about view it has the mission statement-->

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <h3>Mission:</h3>

		<ul>
			<h4>
				<li>Provide an efficient means for researchers with analytical needs to contribute data to their specific biological field of interest.</li>
				<br>
				<li>Provide opportunities for students and faculty to contribute their bioinformatics analysis skills to real world biological research projects.</li>
			</h4>
		</ul> <br>
		<h4> We want users to take part in the research community, as this site is dedicated to the pursuit greater knowledge. Here you can contribute to the community by helping out fellow researchers solve problems and add to our body of knowledge. Whether you are a seasoned vet or a brand new researcher this is a place to get started. There are many research topics to choose from, hope you find a topic to your liking! Good luck with your research.
    	</h4>
    </p>
</div>
