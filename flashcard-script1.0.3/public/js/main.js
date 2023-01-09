var wordList;
var cur = 0;
var totalCount = 0;
var cardList = [];
var Amax = 0;
var Emax = 0;
var Wmax = 0;
var wordIndex = 0, adIndex = 0, emailIndex = 0;
var g_index = 0;
var isSubscribed = false;
var isBelowFirstTime = true;

$(function() {
	$(".status-text").hide();
	$("#flashCard-container").hide();
	$(".bottom").hide();
	//console.log(exercise);
	selectCategory(exercise.category)
});

function paddingZero(val, length) {
	var fullVal = ('00' + val);
	return fullVal.substring(fullVal.length - length);
}

function showFlashCard(idx) {
	$("#flashCard-container").show();
	$(".subscribe-container").hide();
	$(".ad-container").hide();
	$(".ad-container").html("");
	if(exercise.enableBelowExerciseAd == 'Y' && settings.belowAdSpot && isBelowFirstTime) {
		isBelowFirstTime = false;
		$(".ad-container-bottom").show();
		$(".ad-container-bottom").html(settings.belowAdSpot);
	}

	$('.flip-container').removeClass('flip');
	cur = idx;
	$(".status-text").html(idx + " / " + wordList.length);
	$(".front .flashcard").html(wordList[idx-1].word);

	var exampleTitle = "";
	if(wordList[idx-1].example != "")
		exampleTitle = "Example";
	$(".back .flashcard").html(wordList[idx-1].word + '<div style="text-align:center;padding-top:10px;"> \
			<p style="font-size:14px;">' + wordList[idx-1].desc + '</p> \
			<p style="font-size:18px;">' + exampleTitle + '</p> \
			<p style="font-size:12px;font-style:italic">' + wordList[idx-1].example + '</p> \
		</div>');

	if(wordList[idx-1].audio != null && wordList[idx-1].audio != 'null') {
		$("div.audio").show();
		playAudio();
	} else {
		$("div.audio").hide();
	}
}

function showAdsense() {
	$("#flashCard-container").hide();
	$(".subscribe-container").hide();
	$(".ad-container").show();
	$(".ad-container").html(settings.inlineAdSpot);
	if(exercise.enableBelowExerciseAd == 'Y' && settings.belowAdSpot && isBelowFirstTime) {
		isBelowFirstTime = false;
		$(".ad-container-bottom").show();
		$(".ad-container-bottom").html(settings.belowAdSpot);
	}
	console.log("adsense");
}

function showEmailSubscribe() {
	$(".btn-subscribe").html('SUBSCRIBE');
	$(".btn-subscribe").removeClass("disabled");
	$("#subscribe-step1").show();
	$("#subscribe-step2").hide();

	$(".ad-container").html("");
	$("#flashCard-container").hide();
	$(".subscribe-container").show();
	$(".ad-container").hide();
	if(exercise.enableBelowExerciseAd == 'Y' && settings.belowAdSpot && isBelowFirstTime) {
		isBelowFirstTime = false;
		$(".ad-container-bottom").show();
		$(".ad-container-bottom").html(settings.belowAdSpot);
	}
	console.log("email");
}

function playAudio() {
	var audioElm = document.getElementById("audioFile");
	audioElm.src = relationURL + "/public/" + wordList[cur-1].audio;
	audioElm.play();
}

function goNext() {
	console.log("goNext", g_index, cardList.length);
	if(g_index == cardList.length) {
		return;
	}
	g_index++;
	var card = cardList[g_index - 1];
	if(card.type == 'W') {
		showFlashCard(cur + 1);
	} else if(card.type == 'A'){
		showAdsense();
	} else {
		if(isSubscribed)
			goNext();
		else
			showEmailSubscribe();
	}

	if(g_index == cardList.length) {
		if(cardList[g_index - 1].type != 'W')
			cur++;
	}
}

function goPrev() {
	console.log("goPrev", g_index, cardList.length);
	if(g_index == 1)
		return;
	g_index--;
	var card = cardList[g_index - 1];
	if(card.type == 'W') {
		showFlashCard(cur - 1);
	} else if(card.type == 'A'){
		showAdsense();
	} else {
		if(isSubscribed)
			goPrev();
		else
			showEmailSubscribe();
	}
}

function restart() {
	g_index = 0;
	cur = 0;
	goNext();
}

function selectCategory(catId) {
	if(catId == "") {
		catId = exercise.category;
	}
	$.get(relationURL + "/getWords?categoryId=" + catId,function(data, status){
		if(status == 'success') {
			if(data.length == 0) {
				$(".status-text").hide();
				$("#flashCard-container").hide();
				$(".bottom").hide();
				return;
			}
			$(".status-text").show();
			$("#flashCard-container").show();
			$(".bottom").show();
			if(random == 1)
				wordList = makeRandom(data);
			else
				wordList = data;
			var adCount, emailCount;

			console.log(exercise, wordList);
			if((exercise.enableInlineAd == 'Y' && exercise.adCount > 0) || (exercise.enableEmailMarketing == 'Y' && exercise.subscriptionCount > 0)) {
				adCount = (exercise.enableInlineAd == 'Y' && exercise.adCount)?Number(exercise.adCount):0;
				emailCount = (exercise.enableEmailMarketing == 'Y'&&exercise.subscriptionCount)?Number(exercise.subscriptionCount):0;
				Amax = Math.min(Math.floor(wordList.length * adCount / (adCount + emailCount)), adCount);
				console.log(adCount, (wordList.length * adCount / (adCount + emailCount)));
				Emax = Math.min(Math.floor(wordList.length * emailCount / (adCount + emailCount)), emailCount);
			}

			cardList = [];
			totalCount = wordList.length + Amax + Emax;
			Wmax = wordList.length - Amax - Emax;

			console.log("summary", adCount,emailCount,  totalCount, Amax, Emax, Wmax);
			if(Amax + Emax > 0) {
				//random schedule, but keep some rule
				wordIndex = 0; adIndex = 0; emailIndex = 0;
				var tryCnt = 0;
				while(cardList.length < totalCount) {
					getRandomCardData();
					tryCnt++;
					//console.log(tryCnt);
					if(tryCnt > 1000) break;
				}

				if(cardList.length > totalCount)
					cardList.pop();
			} else {
				wordList.map(function(o){
					cardList.push({
						type:"W",
						data:o
					})
				})
			}

			//console.log("cardList", cardList);

			//ad/email processing
			g_index = 0;
			cur = 0;
			goNext();
			//showFlashCard(1);
		} else {
			$(".status-text").hide();
			$("#flashCard-container").hide();
		}
	});
}

function makeRandom(list) {
	var ret = [];
	while(list.length > 0) {
		var rand = Math.floor(Math.random() * list.length);
		ret.push(list[rand]);
		list.splice(rand, 1);
	}

	return ret;
}

function getRandomCardData() {
	var idx = cardList.length;
	if(idx == 0) {
		wordIndex++;
		cardList.push({
			type:"W",
			data:wordList[0]
		});
		return;
	}

	var mod = Math.floor(Math.random() * 1000) % 3;
	//console.log(mod, wordIndex, adIndex, emailIndex);
	if(mod == 0 && wordIndex < Wmax) {
		wordIndex++;
		cardList.push({
			type:"W",
			data:wordList[wordIndex - 1]
		});
		return;
	} else if(mod == 1 && adIndex < Amax) {
		adIndex++;
		cardList.push({
			type:"A"
		});

		cardList.push({
			type:"W",
			data:wordList[wordIndex - 1]
		});

		return;
	} else if(mod == 2 && emailIndex < Emax) {
		emailIndex++;
		cardList.push({
			type:"E"
		});

		cardList.push({
			type:"W",
			data:wordList[wordIndex - 1]
		});

		return;
	}
}

function subscribe() {
	var email = $("#email").val();
	if(email == "")
		return;

	$(".btn-subscribe").html('<span class="glyphicon glyphicon-refresh spinning"></span>&nbsp;SUBSCRIBE');
	$(".btn-subscribe").addClass("disabled");

	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	if(email != "") {
		$.ajax({
			url:relationURL + "/subscribe",
			data:{
				email:email,
				_token: CSRF_TOKEN
			},
			method: 'POST',
			dataType:"json"
		}).then(function(ret){
			console.log(ret);
			$(".btn-subscribe").removeClass("disabled");
			$(".btn-subscribe").html('SUBSCRIBE');
			$("#subscribe-step1").hide();
			$("#subscribe-step2").show();
			isSubscribed = true;
		}, function(err){
			console.log(err);
			$(".btn-subscribe").removeClass("disabled");
			$(".btn-subscribe").html('SUBSCRIBE');
		})
	}
}