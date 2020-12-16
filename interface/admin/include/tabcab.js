var oO =
{
	'tempoXHR': 3000,
	'tempoRefresh': 1500,
	'url': './cabine.php',

	connect: function(oElem, sEvType, fn, bCapture)
	{
		return document.addEventListener ?
			oElem.addEventListener(sEvType, fn, bCapture):
			oElem.attachEvent ?
				oElem.attachEvent('on' + sEvType, fn):
				false;
	},

	aTag: function(oEl, sTag)
	{
		return oEl.getElementsByTagName(sTag);
	},

	bXHRSupport: (typeof XMLHttpRequest != "undefined"),

	bActiveXSupport: (window.ActiveXObject),

	aMSXML: ["Microsoft.XMLHTTP",
		"MSXML2.XMLHTTP", "MSXML2.XMLHTTP.3.0",
		"MSXML2.XMLHTTP.4.0", "MSXML2.XMLHTTP.5.0",
		"MSXML2.XMLHTTP.6.0", "MSXML2.XMLHTTP.7.0"],

	createXHR: function()
	{
		if(oO.bXHRSupport)
			return new XMLHttpRequest;
		else if(oO.bActiveXSupport)
		{
			var iI;
			
			iI = oO.aMSXML.length;

			do
			{
				try
				{
					return new ActiveXObject(oO.aMSXML[--iI]);
				}
				catch(oError) { };
			}
			while(iI > 0);
			
			throw new Error("L'objet oXHR n'a pas été créé");
		}
	},

	getXHR: function(oReq)
	{
		var oXHR, oTimer;
		
		oXHR = oO.createXHR();
		oO.oReq = oReq;

		oXHR.open(oO.oReq['method'], oO.oReq['url'], true);

		oTimer = setTimeout(
			function()
			{
				if(oXHR)
					return oXHR.abort();
			},
			oO['tempoXHR']
		);

		oXHR.onreadystatechange = function()
		{
			if(oXHR.readyState === 4)
				if(oXHR.status && /200|304/.test(oXHR.status))
				{
					clearTimeout(oTimer);

				oO.oReq['response'] = oXHR.responseText;

				if(oO.oReq['callback'])
					(oO.oReq['callback'])();
				}
		}

		oXHR.setRequestHeader("If-Modified-Since", "Sat, 1 Jan 2000 00:00:00 GMT");

		if(oO.oReq['method'] === 'post')
			oXHR.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

		return oO.oReq['method'] === 'get' ?
			oXHR.send(null):
			oXHR.send(oO.oReq['param']);
	},

	control: function(oEl)
	{
		return setInterval(
			function()
			{
				return oO.getXHR(
					{
						'cible': oEl,
						'url': oO['url'],
						'method': 'get',
						'callback': function()
						{
							return oO.refresh(oO.oReq['cible'], oO.oReq['response']);
						}
					}
				);
			},
			oO['tempoRefresh']
		);
	},
	
	refresh: function(oEl, sResponse)
	{
		return oEl.innerHTML = sResponse;
	},
	
	init: function()
	{
		var aDivs, iDiv;
		
		aDivs = oO.aTag(document, 'div');
		iDiv = aDivs.length;
		
		do if(aDivs[--iDiv].className =='tabcab')
			oO.control(aDivs[iDiv]);
		while(iDiv > 0);
		
		return true;
	}
};

oO.connect(window, 'load', oO.init, false);