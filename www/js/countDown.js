function CountdownTimer( elemID, timeLimit, limitMessage ) {
	this.initialize.apply( this, arguments );
}
CountdownTimer.prototype = 	{
	initialize: function( elemID, timeLimit, limitMessage ) {
		this.elem = document.getElementById( elemID );
		this.timeLimit = timeLimit;
		this.limitMessage = limitMessage;
	},
	countDown : function()	{
		var	timer;
		var	today = new Date()
		var	days = Math.floor( ( this.timeLimit - today ) / ( 24 * 60 * 60 * 1000 ) );
		var	hours = Math.floor( ( ( this.timeLimit - today ) % ( 24 * 60 * 60 * 1000 ) ) / ( 60 * 60 * 1000 ) );
		var	mins = Math.floor( ( ( this.timeLimit - today ) % ( 24 * 60 * 60 * 1000 ) ) / ( 60 * 1000 ) ) % 60;
		var	secs = Math.floor( ( ( this.timeLimit - today ) % ( 24 * 60 * 60 * 1000 ) ) / 1000 ) % 60 % 60;
		var	milis = Math.floor( ( ( this.timeLimit - today ) % ( 24 * 60 * 60 * 1000 ) ) / 10 ) % 100;
		var	me = this;
		if( ( this.timeLimit - today ) > 0 ){
			if( days < 1 ) {
				txt = "";
			} else {
				txt = '<span style="color:#F00;">' +  days + '</span>日';
			}
			timer = txt + '<span style="color:#F00;">' + hours + '</span>時間<span style="color:#F00;">' + this.addZero( mins ) + '</span>分<span style="color:#F00;">'+ this.addZero( secs ) + '</span>秒<span style="color:#F00;">'  + this.addZero( milis ) + '</span>';
			this.elem.innerHTML = timer;
			tid = setTimeout( function() { me.countDown(); }, 10 );

		}else{
			this.elem.innerHTML = this.limitMessage;
			return;
		}
	},
	addZero : function( num )	{
		num = '00' + num;
		str = num.substring( num.length - 2, num.length );
		return str ;
	}
}
function countdown(elementID, sYer, sMon, sDat, sH, sM) {
	var elemID = elementID;
	var year = sYer;
	var month = sMon;
	var day = sDat;
	var hh = sH;
	var mm = sM;

	// 期限終了後のメッセージ
	var limitMessage	=	'終了しました';
	var timeLimit = new Date( year, month-1, day, hh, mm );
	var timer = new CountdownTimer( elemID, timeLimit, limitMessage );
	timer.countDown();
}