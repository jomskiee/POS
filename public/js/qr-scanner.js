/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/qr-scanner/qr-scanner.min.js":
/*!***************************************************!*\
  !*** ./node_modules/qr-scanner/qr-scanner.min.js ***!
  \***************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
class e{constructor(a,b,c,d,f){this._legacyCanvasSize=e.DEFAULT_CANVAS_SIZE;this._preferredCamera="environment";this._maxScansPerSecond=25;this._lastScanTimestamp=-1;this._destroyed=this._flashOn=this._paused=this._active=!1;this.$video=a;this.$canvas=document.createElement("canvas");c&&"object"===typeof c?this._onDecode=b:(c||d||f?console.warn("You're using a deprecated version of the QrScanner constructor which will be removed in the future"):console.warn("Note that the type of the scan result passed to onDecode will change in the future. To already switch to the new api today, you can pass returnDetailedScanResult: true."),
this._legacyOnDecode=b);b="object"===typeof c?c:{};this._onDecodeError=b.onDecodeError||("function"===typeof c?c:this._onDecodeError);this._calculateScanRegion=b.calculateScanRegion||("function"===typeof d?d:this._calculateScanRegion);this._preferredCamera=b.preferredCamera||f||this._preferredCamera;this._legacyCanvasSize="number"===typeof c?c:"number"===typeof d?d:this._legacyCanvasSize;this._maxScansPerSecond=b.maxScansPerSecond||this._maxScansPerSecond;this._onPlay=this._onPlay.bind(this);this._onLoadedMetaData=
this._onLoadedMetaData.bind(this);this._onVisibilityChange=this._onVisibilityChange.bind(this);this._updateOverlay=this._updateOverlay.bind(this);a.disablePictureInPicture=!0;a.playsInline=!0;a.muted=!0;let h=!1;a.hidden&&(a.hidden=!1,h=!0);document.body.contains(a)||(document.body.appendChild(a),h=!0);c=a.parentElement;if(b.highlightScanRegion||b.highlightCodeOutline){d=!!b.overlay;this.$overlay=b.overlay||document.createElement("div");f=this.$overlay.style;f.position="absolute";f.display="none";
f.pointerEvents="none";this.$overlay.classList.add("scan-region-highlight");if(!d&&b.highlightScanRegion){this.$overlay.innerHTML='<svg class="scan-region-highlight-svg" viewBox="0 0 238 238" preserveAspectRatio="none" style="position:absolute;width:100%;height:100%;left:0;top:0;fill:none;stroke:#e9b213;stroke-width:4;stroke-linecap:round;stroke-linejoin:round"><path d="M31 2H10a8 8 0 0 0-8 8v21M207 2h21a8 8 0 0 1 8 8v21m0 176v21a8 8 0 0 1-8 8h-21m-176 0H10a8 8 0 0 1-8-8v-21"/></svg>';try{this.$overlay.firstElementChild.animate({transform:["scale(.98)",
"scale(1.01)"]},{duration:400,iterations:Infinity,direction:"alternate",easing:"ease-in-out"})}catch(m){}c.insertBefore(this.$overlay,this.$video.nextSibling)}b.highlightCodeOutline&&(this.$overlay.insertAdjacentHTML("beforeend",'<svg class="code-outline-highlight" preserveAspectRatio="none" style="display:none;width:100%;height:100%;fill:none;stroke:#e9b213;stroke-width:5;stroke-dasharray:25;stroke-linecap:round;stroke-linejoin:round"><polygon/></svg>'),this.$codeOutlineHighlight=this.$overlay.lastElementChild)}this._scanRegion=
this._calculateScanRegion(a);requestAnimationFrame(()=>{let m=window.getComputedStyle(a);"none"===m.display&&(a.style.setProperty("display","block","important"),h=!0);"visible"!==m.visibility&&(a.style.setProperty("visibility","visible","important"),h=!0);h&&(console.warn("QrScanner has overwritten the video hiding style to avoid Safari stopping the playback."),a.style.opacity="0",a.style.width="0",a.style.height="0",this.$overlay&&this.$overlay.parentElement&&this.$overlay.parentElement.removeChild(this.$overlay),
delete this.$overlay,delete this.$codeOutlineHighlight);this.$overlay&&this._updateOverlay()});a.addEventListener("play",this._onPlay);a.addEventListener("loadedmetadata",this._onLoadedMetaData);document.addEventListener("visibilitychange",this._onVisibilityChange);window.addEventListener("resize",this._updateOverlay);this._qrEnginePromise=e.createQrEngine()}static set WORKER_PATH(a){console.warn("Setting QrScanner.WORKER_PATH is not required and not supported anymore. Have a look at the README for new setup instructions.")}static async hasCamera(){try{return!!(await e.listCameras(!1)).length}catch(a){return!1}}static async listCameras(a=
!1){if(!navigator.mediaDevices)return[];let b=async()=>(await navigator.mediaDevices.enumerateDevices()).filter(d=>"videoinput"===d.kind),c;try{a&&(await b()).every(d=>!d.label)&&(c=await navigator.mediaDevices.getUserMedia({audio:!1,video:!0}))}catch(d){}try{return(await b()).map((d,f)=>({id:d.deviceId,label:d.label||(0===f?"Default Camera":`Camera ${f+1}`)}))}finally{c&&(console.warn("Call listCameras after successfully starting a QR scanner to avoid creating a temporary video stream"),e._stopVideoStream(c))}}async hasFlash(){let a;
try{if(this.$video.srcObject){if(!(this.$video.srcObject instanceof MediaStream))return!1;a=this.$video.srcObject}else a=(await this._getCameraStream()).stream;return"torch"in a.getVideoTracks()[0].getSettings()}catch(b){return!1}finally{a&&a!==this.$video.srcObject&&(console.warn("Call hasFlash after successfully starting the scanner to avoid creating a temporary video stream"),e._stopVideoStream(a))}}isFlashOn(){return this._flashOn}async toggleFlash(){this._flashOn?await this.turnFlashOff():await this.turnFlashOn()}async turnFlashOn(){if(!this._flashOn&&
!this._destroyed&&(this._flashOn=!0,this._active&&!this._paused))try{if(!await this.hasFlash())throw"No flash available";await this.$video.srcObject.getVideoTracks()[0].applyConstraints({advanced:[{torch:!0}]})}catch(a){throw this._flashOn=!1,a;}}async turnFlashOff(){this._flashOn&&(this._flashOn=!1,await this._restartVideoStream())}destroy(){this.$video.removeEventListener("loadedmetadata",this._onLoadedMetaData);this.$video.removeEventListener("play",this._onPlay);document.removeEventListener("visibilitychange",
this._onVisibilityChange);window.removeEventListener("resize",this._updateOverlay);this._destroyed=!0;this._flashOn=!1;this.stop();e._postWorkerMessage(this._qrEnginePromise,"close")}async start(){if(this._destroyed)throw Error("The QR scanner can not be started as it had been destroyed.");if(!this._active||this._paused)if("https:"!==window.location.protocol&&console.warn("The camera stream is only accessible if the page is transferred via https."),this._active=!0,!document.hidden)if(this._paused=
!1,this.$video.srcObject)await this.$video.play();else try{let {stream:a,facingMode:b}=await this._getCameraStream();!this._active||this._paused?e._stopVideoStream(a):(this._setVideoMirror(b),this.$video.srcObject=a,await this.$video.play(),this._flashOn&&(this._flashOn=!1,this.turnFlashOn().catch(()=>{})))}catch(a){if(!this._paused)throw this._active=!1,a;}}stop(){this.pause();this._active=!1}async pause(a=!1){this._paused=!0;if(!this._active)return!0;this.$video.pause();this.$overlay&&(this.$overlay.style.display=
"none");let b=()=>{this.$video.srcObject instanceof MediaStream&&(e._stopVideoStream(this.$video.srcObject),this.$video.srcObject=null)};if(a)return b(),!0;await new Promise(c=>setTimeout(c,300));if(!this._paused)return!1;b();return!0}async setCamera(a){a!==this._preferredCamera&&(this._preferredCamera=a,await this._restartVideoStream())}static async scanImage(a,b,c,d,f=!1,h=!1){let m,n=!1;b&&("scanRegion"in b||"qrEngine"in b||"canvas"in b||"disallowCanvasResizing"in b||"alsoTryWithoutScanRegion"in
b||"returnDetailedScanResult"in b)?(m=b.scanRegion,c=b.qrEngine,d=b.canvas,f=b.disallowCanvasResizing||!1,h=b.alsoTryWithoutScanRegion||!1,n=!0):b||c||d||f||h?console.warn("You're using a deprecated api for scanImage which will be removed in the future."):console.warn("Note that the return type of scanImage will change in the future. To already switch to the new api today, you can pass returnDetailedScanResult: true.");b=!!c;try{let p,k;[c,p]=await Promise.all([c||e.createQrEngine(),e._loadImage(a)]);
[d,k]=e._drawToCanvas(p,m,d,f);let q;if(c instanceof Worker){let g=c;b||e._postWorkerMessageSync(g,"inversionMode","both");q=await new Promise((l,v)=>{let w,u,r,y=-1;u=t=>{t.data.id===y&&(g.removeEventListener("message",u),g.removeEventListener("error",r),clearTimeout(w),null!==t.data.data?l({data:t.data.data,cornerPoints:e._convertPoints(t.data.cornerPoints,m)}):v(e.NO_QR_CODE_FOUND))};r=t=>{g.removeEventListener("message",u);g.removeEventListener("error",r);clearTimeout(w);v("Scanner error: "+(t?
t.message||t:"Unknown Error"))};g.addEventListener("message",u);g.addEventListener("error",r);w=setTimeout(()=>r("timeout"),1E4);let x=k.getImageData(0,0,d.width,d.height);y=e._postWorkerMessageSync(g,"decode",x,[x.data.buffer])})}else q=await Promise.race([new Promise((g,l)=>window.setTimeout(()=>l("Scanner error: timeout"),1E4)),(async()=>{try{var [g]=await c.detect(d);if(!g)throw e.NO_QR_CODE_FOUND;return{data:g.rawValue,cornerPoints:e._convertPoints(g.cornerPoints,m)}}catch(l){g=l.message||l;
if(/not implemented|service unavailable/.test(g))return e._disableBarcodeDetector=!0,e.scanImage(a,{scanRegion:m,canvas:d,disallowCanvasResizing:f,alsoTryWithoutScanRegion:h});throw`Scanner error: ${g}`;}})()]);return n?q:q.data}catch(p){if(!m||!h)throw p;let k=await e.scanImage(a,{qrEngine:c,canvas:d,disallowCanvasResizing:f});return n?k:k.data}finally{b||e._postWorkerMessage(c,"close")}}setGrayscaleWeights(a,b,c,d=!0){e._postWorkerMessage(this._qrEnginePromise,"grayscaleWeights",{red:a,green:b,
blue:c,useIntegerApproximation:d})}setInversionMode(a){e._postWorkerMessage(this._qrEnginePromise,"inversionMode",a)}static async createQrEngine(a){a&&console.warn("Specifying a worker path is not required and not supported anymore.");a=()=>__webpack_require__.e(/*! import() */ "node_modules_qr-scanner_qr-scanner-worker_min_js").then(__webpack_require__.bind(__webpack_require__, /*! ./qr-scanner-worker.min.js */ "./node_modules/qr-scanner/qr-scanner-worker.min.js")).then(c=>c.createWorker());if(!(!e._disableBarcodeDetector&&"BarcodeDetector"in window&&BarcodeDetector.getSupportedFormats&&(await BarcodeDetector.getSupportedFormats()).includes("qr_code")))return a();let b=navigator.userAgentData;
return b&&b.brands.some(({brand:c})=>/Chromium/i.test(c))&&/mac ?OS/i.test(b.platform)&&await b.getHighEntropyValues(["architecture","platformVersion"]).then(({architecture:c,platformVersion:d})=>/arm/i.test(c||"arm")&&13<=parseInt(d||"13")).catch(()=>!0)?a():new BarcodeDetector({formats:["qr_code"]})}_onPlay(){this._scanRegion=this._calculateScanRegion(this.$video);this._updateOverlay();this.$overlay&&(this.$overlay.style.display="");this._scanFrame()}_onLoadedMetaData(){this._scanRegion=this._calculateScanRegion(this.$video);
this._updateOverlay()}_onVisibilityChange(){document.hidden?this.pause():this._active&&this.start()}_calculateScanRegion(a){let b=Math.round(2/3*Math.min(a.videoWidth,a.videoHeight));return{x:Math.round((a.videoWidth-b)/2),y:Math.round((a.videoHeight-b)/2),width:b,height:b,downScaledWidth:this._legacyCanvasSize,downScaledHeight:this._legacyCanvasSize}}_updateOverlay(){requestAnimationFrame(()=>{if(this.$overlay){var a=this.$video,b=a.videoWidth,c=a.videoHeight,d=a.offsetWidth,f=a.offsetHeight,h=a.offsetLeft,
m=a.offsetTop,n=window.getComputedStyle(a),p=n.objectFit,k=b/c,q=d/f;switch(p){case "none":var g=b;var l=c;break;case "fill":g=d;l=f;break;default:("cover"===p?k>q:k<q)?(l=f,g=l*k):(g=d,l=g/k),"scale-down"===p&&(g=Math.min(g,b),l=Math.min(l,c))}var [v,w]=n.objectPosition.split(" ").map((r,y)=>{const x=parseFloat(r);return r.endsWith("%")?(y?f-l:d-g)*x/100:x});n=this._scanRegion.width||b;q=this._scanRegion.height||c;p=this._scanRegion.x||0;var u=this._scanRegion.y||0;k=this.$overlay.style;k.width=
`${n/b*g}px`;k.height=`${q/c*l}px`;k.top=`${m+w+u/c*l}px`;c=/scaleX\(-1\)/.test(a.style.transform);k.left=`${h+(c?d-v-g:v)+(c?b-p-n:p)/b*g}px`;k.transform=a.style.transform}})}static _convertPoints(a,b){if(!b)return a;let c=b.x||0,d=b.y||0,f=b.width&&b.downScaledWidth?b.width/b.downScaledWidth:1;b=b.height&&b.downScaledHeight?b.height/b.downScaledHeight:1;for(let h of a)h.x=h.x*f+c,h.y=h.y*b+d;return a}_scanFrame(){!this._active||this.$video.paused||this.$video.ended||("requestVideoFrameCallback"in
this.$video?this.$video.requestVideoFrameCallback.bind(this.$video):requestAnimationFrame)(async()=>{if(!(1>=this.$video.readyState)){var a=Date.now()-this._lastScanTimestamp,b=1E3/this._maxScansPerSecond;a<b&&await new Promise(d=>setTimeout(d,b-a));this._lastScanTimestamp=Date.now();try{var c=await e.scanImage(this.$video,{scanRegion:this._scanRegion,qrEngine:this._qrEnginePromise,canvas:this.$canvas})}catch(d){if(!this._active)return;this._onDecodeError(d)}!e._disableBarcodeDetector||await this._qrEnginePromise instanceof
Worker||(this._qrEnginePromise=e.createQrEngine());c?(this._onDecode?this._onDecode(c):this._legacyOnDecode&&this._legacyOnDecode(c.data),this.$codeOutlineHighlight&&(clearTimeout(this._codeOutlineHighlightRemovalTimeout),this._codeOutlineHighlightRemovalTimeout=void 0,this.$codeOutlineHighlight.setAttribute("viewBox",`${this._scanRegion.x||0} `+`${this._scanRegion.y||0} `+`${this._scanRegion.width||this.$video.videoWidth} `+`${this._scanRegion.height||this.$video.videoHeight}`),this.$codeOutlineHighlight.firstElementChild.setAttribute("points",
c.cornerPoints.map(({x:d,y:f})=>`${d},${f}`).join(" ")),this.$codeOutlineHighlight.style.display="")):this.$codeOutlineHighlight&&!this._codeOutlineHighlightRemovalTimeout&&(this._codeOutlineHighlightRemovalTimeout=setTimeout(()=>this.$codeOutlineHighlight.style.display="none",100))}this._scanFrame()})}_onDecodeError(a){a!==e.NO_QR_CODE_FOUND&&console.log(a)}async _getCameraStream(){if(!navigator.mediaDevices)throw"Camera not found.";let a=/^(environment|user)$/.test(this._preferredCamera)?"facingMode":
"deviceId",b=[{width:{min:1024}},{width:{min:768}},{}],c=b.map(d=>Object.assign({},d,{[a]:{exact:this._preferredCamera}}));for(let d of[...c,...b])try{let f=await navigator.mediaDevices.getUserMedia({video:d,audio:!1}),h=this._getFacingMode(f)||(d.facingMode?this._preferredCamera:"environment"===this._preferredCamera?"user":"environment");return{stream:f,facingMode:h}}catch(f){}throw"Camera not found.";}async _restartVideoStream(){let a=this._paused;await this.pause(!0)&&!a&&this._active&&await this.start()}static _stopVideoStream(a){for(let b of a.getTracks())b.stop(),
a.removeTrack(b)}_setVideoMirror(a){this.$video.style.transform="scaleX("+("user"===a?-1:1)+")"}_getFacingMode(a){return(a=a.getVideoTracks()[0])?/rear|back|environment/i.test(a.label)?"environment":/front|user|face/i.test(a.label)?"user":null:null}static _drawToCanvas(a,b,c,d=!1){c=c||document.createElement("canvas");let f=b&&b.x?b.x:0,h=b&&b.y?b.y:0,m=b&&b.width?b.width:a.videoWidth||a.width,n=b&&b.height?b.height:a.videoHeight||a.height;d||(d=b&&b.downScaledWidth?b.downScaledWidth:m,b=b&&b.downScaledHeight?
b.downScaledHeight:n,c.width!==d&&(c.width=d),c.height!==b&&(c.height=b));b=c.getContext("2d",{alpha:!1});b.imageSmoothingEnabled=!1;b.drawImage(a,f,h,m,n,0,0,c.width,c.height);return[c,b]}static async _loadImage(a){if(a instanceof Image)return await e._awaitImageLoad(a),a;if(a instanceof HTMLVideoElement||a instanceof HTMLCanvasElement||a instanceof SVGImageElement||"OffscreenCanvas"in window&&a instanceof OffscreenCanvas||"ImageBitmap"in window&&a instanceof ImageBitmap)return a;if(a instanceof
File||a instanceof Blob||a instanceof URL||"string"===typeof a){let b=new Image;b.src=a instanceof File||a instanceof Blob?URL.createObjectURL(a):a.toString();try{return await e._awaitImageLoad(b),b}finally{(a instanceof File||a instanceof Blob)&&URL.revokeObjectURL(b.src)}}else throw"Unsupported image type.";}static async _awaitImageLoad(a){a.complete&&0!==a.naturalWidth||await new Promise((b,c)=>{let d=f=>{a.removeEventListener("load",d);a.removeEventListener("error",d);f instanceof ErrorEvent?
c("Image load error"):b()};a.addEventListener("load",d);a.addEventListener("error",d)})}static async _postWorkerMessage(a,b,c,d){return e._postWorkerMessageSync(await a,b,c,d)}static _postWorkerMessageSync(a,b,c,d){if(!(a instanceof Worker))return-1;let f=e._workerMessageId++;a.postMessage({id:f,type:b,data:c},d);return f}}e.DEFAULT_CANVAS_SIZE=400;e.NO_QR_CODE_FOUND="No QR code found";e._disableBarcodeDetector=!1;e._workerMessageId=0;/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (e);
//# sourceMappingURL=qr-scanner.min.js.map


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/ensure chunk */
/******/ 	(() => {
/******/ 		__webpack_require__.f = {};
/******/ 		// This file contains only the entry chunk.
/******/ 		// The chunk loading function for additional chunks
/******/ 		__webpack_require__.e = (chunkId) => {
/******/ 			return Promise.all(Object.keys(__webpack_require__.f).reduce((promises, key) => {
/******/ 				__webpack_require__.f[key](chunkId, promises);
/******/ 				return promises;
/******/ 			}, []));
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/get javascript chunk filename */
/******/ 	(() => {
/******/ 		// This function allow to reference async chunks
/******/ 		__webpack_require__.u = (chunkId) => {
/******/ 			// return url for filenames not based on template
/******/ 			if (chunkId === "node_modules_qr-scanner_qr-scanner-worker_min_js") return "js/" + chunkId + ".js";
/******/ 			// return url for filenames based on template
/******/ 			return undefined;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/get mini-css chunk filename */
/******/ 	(() => {
/******/ 		// This function allow to reference all chunks
/******/ 		__webpack_require__.miniCssF = (chunkId) => {
/******/ 			// return url for filenames based on template
/******/ 			return undefined;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/load script */
/******/ 	(() => {
/******/ 		var inProgress = {};
/******/ 		// data-webpack is not used as build has no uniqueName
/******/ 		// loadScript function to load a script via script tag
/******/ 		__webpack_require__.l = (url, done, key, chunkId) => {
/******/ 			if(inProgress[url]) { inProgress[url].push(done); return; }
/******/ 			var script, needAttach;
/******/ 			if(key !== undefined) {
/******/ 				var scripts = document.getElementsByTagName("script");
/******/ 				for(var i = 0; i < scripts.length; i++) {
/******/ 					var s = scripts[i];
/******/ 					if(s.getAttribute("src") == url) { script = s; break; }
/******/ 				}
/******/ 			}
/******/ 			if(!script) {
/******/ 				needAttach = true;
/******/ 				script = document.createElement('script');
/******/ 		
/******/ 				script.charset = 'utf-8';
/******/ 				script.timeout = 120;
/******/ 				if (__webpack_require__.nc) {
/******/ 					script.setAttribute("nonce", __webpack_require__.nc);
/******/ 				}
/******/ 		
/******/ 		
/******/ 				script.src = url;
/******/ 			}
/******/ 			inProgress[url] = [done];
/******/ 			var onScriptComplete = (prev, event) => {
/******/ 				// avoid mem leaks in IE.
/******/ 				script.onerror = script.onload = null;
/******/ 				clearTimeout(timeout);
/******/ 				var doneFns = inProgress[url];
/******/ 				delete inProgress[url];
/******/ 				script.parentNode && script.parentNode.removeChild(script);
/******/ 				doneFns && doneFns.forEach((fn) => (fn(event)));
/******/ 				if(prev) return prev(event);
/******/ 			}
/******/ 			var timeout = setTimeout(onScriptComplete.bind(null, undefined, { type: 'timeout', target: script }), 120000);
/******/ 			script.onerror = onScriptComplete.bind(null, script.onerror);
/******/ 			script.onload = onScriptComplete.bind(null, script.onload);
/******/ 			needAttach && document.head.appendChild(script);
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/publicPath */
/******/ 	(() => {
/******/ 		__webpack_require__.p = "/";
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/qr-scanner": 0
/******/ 		};
/******/ 		
/******/ 		__webpack_require__.f.j = (chunkId, promises) => {
/******/ 				// JSONP chunk loading for javascript
/******/ 				var installedChunkData = __webpack_require__.o(installedChunks, chunkId) ? installedChunks[chunkId] : undefined;
/******/ 				if(installedChunkData !== 0) { // 0 means "already installed".
/******/ 		
/******/ 					// a Promise means "currently loading".
/******/ 					if(installedChunkData) {
/******/ 						promises.push(installedChunkData[2]);
/******/ 					} else {
/******/ 						if(true) { // all chunks have JS
/******/ 							// setup Promise in chunk cache
/******/ 							var promise = new Promise((resolve, reject) => (installedChunkData = installedChunks[chunkId] = [resolve, reject]));
/******/ 							promises.push(installedChunkData[2] = promise);
/******/ 		
/******/ 							// start chunk loading
/******/ 							var url = __webpack_require__.p + __webpack_require__.u(chunkId);
/******/ 							// create error before stack unwound to get useful stacktrace later
/******/ 							var error = new Error();
/******/ 							var loadingEnded = (event) => {
/******/ 								if(__webpack_require__.o(installedChunks, chunkId)) {
/******/ 									installedChunkData = installedChunks[chunkId];
/******/ 									if(installedChunkData !== 0) installedChunks[chunkId] = undefined;
/******/ 									if(installedChunkData) {
/******/ 										var errorType = event && (event.type === 'load' ? 'missing' : event.type);
/******/ 										var realSrc = event && event.target && event.target.src;
/******/ 										error.message = 'Loading chunk ' + chunkId + ' failed.\n(' + errorType + ': ' + realSrc + ')';
/******/ 										error.name = 'ChunkLoadError';
/******/ 										error.type = errorType;
/******/ 										error.request = realSrc;
/******/ 										installedChunkData[1](error);
/******/ 									}
/******/ 								}
/******/ 							};
/******/ 							__webpack_require__.l(url, loadingEnded, "chunk-" + chunkId, chunkId);
/******/ 						}
/******/ 					}
/******/ 				}
/******/ 		};
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		// no on chunks loaded
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 		
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!************************************!*\
  !*** ./resources/js/qr-scanner.js ***!
  \************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var qr_scanner__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! qr-scanner */ "./node_modules/qr-scanner/qr-scanner.min.js");
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _regenerator() { /*! regenerator-runtime -- Copyright (c) 2014-present, Facebook, Inc. -- license (MIT): https://github.com/babel/babel/blob/main/packages/babel-helpers/LICENSE */ var e, t, r = "function" == typeof Symbol ? Symbol : {}, n = r.iterator || "@@iterator", o = r.toStringTag || "@@toStringTag"; function i(r, n, o, i) { var c = n && n.prototype instanceof Generator ? n : Generator, u = Object.create(c.prototype); return _regeneratorDefine2(u, "_invoke", function (r, n, o) { var i, c, u, f = 0, p = o || [], y = !1, G = { p: 0, n: 0, v: e, a: d, f: d.bind(e, 4), d: function d(t, r) { return i = t, c = 0, u = e, G.n = r, a; } }; function d(r, n) { for (c = r, u = n, t = 0; !y && f && !o && t < p.length; t++) { var o, i = p[t], d = G.p, l = i[2]; r > 3 ? (o = l === n) && (u = i[(c = i[4]) ? 5 : (c = 3, 3)], i[4] = i[5] = e) : i[0] <= d && ((o = r < 2 && d < i[1]) ? (c = 0, G.v = n, G.n = i[1]) : d < l && (o = r < 3 || i[0] > n || n > l) && (i[4] = r, i[5] = n, G.n = l, c = 0)); } if (o || r > 1) return a; throw y = !0, n; } return function (o, p, l) { if (f > 1) throw TypeError("Generator is already running"); for (y && 1 === p && d(p, l), c = p, u = l; (t = c < 2 ? e : u) || !y;) { i || (c ? c < 3 ? (c > 1 && (G.n = -1), d(c, u)) : G.n = u : G.v = u); try { if (f = 2, i) { if (c || (o = "next"), t = i[o]) { if (!(t = t.call(i, u))) throw TypeError("iterator result is not an object"); if (!t.done) return t; u = t.value, c < 2 && (c = 0); } else 1 === c && (t = i["return"]) && t.call(i), c < 2 && (u = TypeError("The iterator does not provide a '" + o + "' method"), c = 1); i = e; } else if ((t = (y = G.n < 0) ? u : r.call(n, G)) !== a) break; } catch (t) { i = e, c = 1, u = t; } finally { f = 1; } } return { value: t, done: y }; }; }(r, o, i), !0), u; } var a = {}; function Generator() {} function GeneratorFunction() {} function GeneratorFunctionPrototype() {} t = Object.getPrototypeOf; var c = [][n] ? t(t([][n]())) : (_regeneratorDefine2(t = {}, n, function () { return this; }), t), u = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(c); function f(e) { return Object.setPrototypeOf ? Object.setPrototypeOf(e, GeneratorFunctionPrototype) : (e.__proto__ = GeneratorFunctionPrototype, _regeneratorDefine2(e, o, "GeneratorFunction")), e.prototype = Object.create(u), e; } return GeneratorFunction.prototype = GeneratorFunctionPrototype, _regeneratorDefine2(u, "constructor", GeneratorFunctionPrototype), _regeneratorDefine2(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = "GeneratorFunction", _regeneratorDefine2(GeneratorFunctionPrototype, o, "GeneratorFunction"), _regeneratorDefine2(u), _regeneratorDefine2(u, o, "Generator"), _regeneratorDefine2(u, n, function () { return this; }), _regeneratorDefine2(u, "toString", function () { return "[object Generator]"; }), (_regenerator = function _regenerator() { return { w: i, m: f }; })(); }
function _regeneratorDefine2(e, r, n, t) { var i = Object.defineProperty; try { i({}, "", {}); } catch (e) { i = 0; } _regeneratorDefine2 = function _regeneratorDefine(e, r, n, t) { function o(r, n) { _regeneratorDefine2(e, r, function (e) { return this._invoke(r, n, e); }); } r ? i ? i(e, r, { value: n, enumerable: !t, configurable: !t, writable: !t }) : e[r] = n : (o("next", 0), o("throw", 1), o("return", 2)); }, _regeneratorDefine2(e, r, n, t); }
function asyncGeneratorStep(n, t, e, r, o, a, c) { try { var i = n[a](c), u = i.value; } catch (n) { return void e(n); } i.done ? t(u) : Promise.resolve(u).then(r, o); }
function _asyncToGenerator(n) { return function () { var t = this, e = arguments; return new Promise(function (r, o) { var a = n.apply(t, e); function _next(n) { asyncGeneratorStep(a, r, o, _next, _throw, "next", n); } function _throw(n) { asyncGeneratorStep(a, r, o, _next, _throw, "throw", n); } _next(void 0); }); }; }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }

var QRScanner = /*#__PURE__*/function () {
  function QRScanner() {
    _classCallCheck(this, QRScanner);
    this.scanner = null;
    this.isProcessing = false;
    this.modal = null;
    this.isModalCreated = false;
  }

  /**
   * Open the QR Scanner modal
   */
  return _createClass(QRScanner, [{
    key: "openModal",
    value: function openModal() {
      this.createModal();
      if (this.modal) {
        this.modal.classList.remove('hidden');
      }
    }

    /**
     * Close the QR Scanner modal
     */
  }, {
    key: "closeModal",
    value: function closeModal() {
      var _this = this;
      this.stopScanner();
      if (this.modal) {
        this.modal.classList.add('hidden');
        // Remove modal from DOM
        setTimeout(function () {
          if (_this.modal && _this.modal.parentNode) {
            _this.modal.parentNode.removeChild(_this.modal);
            _this.modal = null;
            _this.isModalCreated = false;
          }
        }, 300);
      }
    }

    /**
     * Create the QR Scanner modal with modern design
     */
  }, {
    key: "createModal",
    value: function createModal() {
      if (this.isModalCreated) return;
      var modalHTML = "\n            <div id=\"qrScannerModal\" class=\"fixed inset-0 z-50 overflow-y-auto hidden\">\n                <div class=\"flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0\">\n                    <!-- Backdrop with blur effect -->\n                    <div class=\"fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity\" aria-hidden=\"true\"></div>\n                    <span class=\"hidden sm:inline-block sm:align-middle sm:h-screen\" aria-hidden=\"true\">&#8203;</span>\n\n                    <!-- Modern Modal Container -->\n                    <div class=\"inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-200\">\n                        <!-- Header with gradient -->\n                        <div class=\"bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4\">\n                            <div class=\"flex items-center justify-between\">\n                                <div class=\"flex items-center space-x-3\">\n                                    <div class=\"flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-white bg-opacity-20 backdrop-blur-sm\">\n                                        <svg class=\"h-6 w-6 text-white\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n                                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z\" />\n                                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 13a3 3 0 11-6 0 3 3 0 016 0z\" />\n                                        </svg>\n                                    </div>\n                                    <div>\n                                        <h3 class=\"text-lg font-semibold text-white\">QR Code Scanner</h3>\n                                        <p class=\"text-blue-100 text-sm\">Point your camera at a QR code</p>\n                                    </div>\n                                </div>\n                                <button id=\"closeScanner\" class=\"flex-shrink-0 p-2 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 transition-all duration-200 backdrop-blur-sm\">\n                                    <svg class=\"h-5 w-5 text-white\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n                                        <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M6 18L18 6M6 6l12 12\" />\n                                    </svg>\n                                </button>\n                            </div>\n                        </div>\n\n                        <!-- Scanner Container -->\n                        <div class=\"bg-gray-50 p-6\">\n                            <!-- Video Container with Modern Frame -->\n                            <div class=\"relative\">\n                                <!-- Scanner Frame with Corner Indicators -->\n                                <div class=\"relative bg-black rounded-xl overflow-hidden shadow-lg\">\n                                    <video id=\"qr-reader\" class=\"w-full h-80 bg-gray-900 object-cover\"></video>\n\n                                    <!-- Scanner Overlay -->\n                                    <div class=\"absolute inset-0 pointer-events-none\">\n                                        <!-- Corner Indicators -->\n                                        <div class=\"absolute top-4 left-4 w-8 h-8 border-l-4 border-t-4 border-blue-400 rounded-tl-lg\"></div>\n                                        <div class=\"absolute top-4 right-4 w-8 h-8 border-r-4 border-t-4 border-blue-400 rounded-tr-lg\"></div>\n                                        <div class=\"absolute bottom-4 left-4 w-8 h-8 border-l-4 border-b-4 border-blue-400 rounded-bl-lg\"></div>\n                                        <div class=\"absolute bottom-4 right-4 w-8 h-8 border-r-4 border-b-4 border-blue-400 rounded-br-lg\"></div>\n\n                                        <!-- Scanning Line Animation -->\n                                        <div id=\"scanning-line\" class=\"absolute left-4 right-4 h-0.5 bg-gradient-to-r from-transparent via-blue-400 to-transparent opacity-0 transition-all duration-1000\"></div>\n\n                                        <!-- Center Target -->\n                                        <div class=\"absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 border-2 border-blue-400 rounded-lg opacity-30\"></div>\n                                    </div>\n                                </div>\n\n                                <!-- Status Display -->\n                                <div id=\"qr-status\" class=\"mt-4 text-center\">\n                                    <div class=\"flex items-center justify-center space-x-2\">\n                                        <div class=\"animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600\"></div>\n                                        <p class=\"text-gray-600 font-medium\">Initializing camera...</p>\n                                    </div>\n                                </div>\n\n                                <!-- Action Buttons -->\n                                <div class=\"mt-6 flex space-x-3\">\n                                    <button id=\"retry-camera\" class=\"flex-1 inline-flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 hidden\">\n                                        <svg class=\"h-4 w-4 mr-2\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n                                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15\" />\n                                        </svg>\n                                        Try Again\n                                    </button>\n                                    <button id=\"close-scanner-btn\" class=\"flex-1 inline-flex items-center justify-center px-4 py-3 border border-transparent rounded-lg text-sm font-medium text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200\">\n                                        <svg class=\"h-4 w-4 mr-2\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n                                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M6 18L18 6M6 6l12 12\" />\n                                        </svg>\n                                        Close Scanner\n                                    </button>\n                                </div>\n                            </div>\n                        </div>\n                    </div>\n                </div>\n            </div>\n        ";
      document.body.insertAdjacentHTML('beforeend', modalHTML);
      this.modal = document.getElementById('qrScannerModal');
      this.isModalCreated = true;
      this.setupModalEventListeners();
    }

    /**
     * Setup modal event listeners
     */
  }, {
    key: "setupModalEventListeners",
    value: function setupModalEventListeners() {
      var _this2 = this;
      // Close buttons
      var closeBtn = document.getElementById('closeScanner');
      var closeScannerBtn = document.getElementById('close-scanner-btn');
      if (closeBtn) {
        closeBtn.addEventListener('click', function () {
          _this2.closeModal();
        });
      }
      if (closeScannerBtn) {
        closeScannerBtn.addEventListener('click', function () {
          _this2.closeModal();
        });
      }

      // Retry camera button
      var retryBtn = document.getElementById('retry-camera');
      if (retryBtn) {
        retryBtn.addEventListener('click', function () {
          _this2.requestCameraPermission();
        });
      }

      // Close modal when clicking outside
      if (this.modal) {
        this.modal.addEventListener('click', function (e) {
          if (e.target === _this2.modal) {
            _this2.closeModal();
          }
        });
      }
    }

    /**
     * Start the QR scanner
     */
  }, {
    key: "startScanner",
    value: (function () {
      var _startScanner = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee() {
        var _this3 = this;
        var videoElement, statusElement, hasCamera, retryBtn, _t;
        return _regenerator().w(function (_context) {
          while (1) switch (_context.p = _context.n) {
            case 0:
              if (!this.isProcessing) {
                _context.n = 1;
                break;
              }
              return _context.a(2);
            case 1:
              videoElement = document.getElementById('qr-reader');
              statusElement = document.getElementById('qr-status');
              if (videoElement) {
                _context.n = 2;
                break;
              }
              return _context.a(2);
            case 2:
              _context.p = 2;
              // Update status with modern loading animation
              if (statusElement) {
                statusElement.innerHTML = "\n                    <div class=\"flex items-center justify-center space-x-2\">\n                        <div class=\"animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600\"></div>\n                        <p class=\"text-blue-600 font-medium\">Requesting camera permission...</p>\n                    </div>\n                ";
              }

              // Check camera permissions first
              _context.n = 3;
              return this.checkCameraPermission();
            case 3:
              hasCamera = _context.v;
              if (hasCamera) {
                _context.n = 4;
                break;
              }
              if (statusElement) {
                statusElement.innerHTML = "\n                        <div class=\"text-center\">\n                            <div class=\"flex items-center justify-center space-x-2 mb-2\">\n                                <svg class=\"h-5 w-5 text-red-500\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n                                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 19.5c-.77.833.192 2.5 1.732 2.5z\" />\n                                </svg>\n                                <p class=\"text-red-600 font-medium\">Camera access denied</p>\n                            </div>\n                            <p class=\"text-gray-500 text-sm\">Please allow camera permissions to scan QR codes</p>\n                        </div>\n                    ";
              }

              // Show retry button
              retryBtn = document.getElementById('retry-camera');
              if (retryBtn) {
                retryBtn.classList.remove('hidden');
              }
              return _context.a(2);
            case 4:
              // Update status
              if (statusElement) {
                statusElement.innerHTML = "\n                    <div class=\"flex items-center justify-center space-x-2\">\n                        <div class=\"animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600\"></div>\n                        <p class=\"text-blue-600 font-medium\">Starting camera...</p>\n                    </div>\n                ";
              }

              // Start the scanner
              this.scanner = new qr_scanner__WEBPACK_IMPORTED_MODULE_0__["default"](videoElement, function (result) {
                _this3.handleScanResult(result.data);
              }, {
                highlightScanRegion: true,
                highlightCodeOutline: true
              });
              _context.n = 5;
              return this.scanner.start();
            case 5:
              // Start scanning line animation
              this.startScanningAnimation();

              // Update status
              if (statusElement) {
                statusElement.innerHTML = "\n                    <div class=\"text-center\">\n                        <div class=\"flex items-center justify-center space-x-2 mb-2\">\n                            <div class=\"w-2 h-2 bg-green-500 rounded-full animate-pulse\"></div>\n                            <p class=\"text-green-600 font-medium\">Camera active</p>\n                        </div>\n                        <p class=\"text-gray-600 text-sm\">Point your camera at a QR code to scan</p>\n                    </div>\n                ";
              }
              _context.n = 7;
              break;
            case 6:
              _context.p = 6;
              _t = _context.v;
              if (statusElement) {
                statusElement.innerHTML = "\n                    <div class=\"text-center\">\n                        <p class=\"text-red-500 mb-2\">Camera Permission Required</p>\n                        <p class=\"text-sm text-gray-600\">Please allow camera access in your browser settings and try again</p>\n                        <button onclick=\"window.qrScanner.requestCameraPermission()\" class=\"mt-2 px-4 py-2 bg-blue-500 text-white rounded text-sm mr-2\">\n                            Try Again\n                        </button>\n                        <button onclick=\"window.qrScanner.closeModal()\" class=\"mt-2 px-4 py-2 bg-gray-500 text-white rounded text-sm\">\n                            Close\n                        </button>\n                    </div>\n                ";
              }
            case 7:
              return _context.a(2);
          }
        }, _callee, this, [[2, 6]]);
      }));
      function startScanner() {
        return _startScanner.apply(this, arguments);
      }
      return startScanner;
    }()
    /**
     * Start scanning line animation
     */
    )
  }, {
    key: "startScanningAnimation",
    value: function startScanningAnimation() {
      var scanningLine = document.getElementById('scanning-line');
      if (scanningLine) {
        // Reset position and opacity
        scanningLine.style.top = '1rem';
        scanningLine.style.opacity = '1';

        // Animate the line
        setTimeout(function () {
          scanningLine.style.top = 'calc(100% - 2rem)';
          scanningLine.style.opacity = '0.8';
        }, 100);

        // Repeat animation
        this.scanningInterval = setInterval(function () {
          scanningLine.style.top = '1rem';
          scanningLine.style.opacity = '1';
          setTimeout(function () {
            scanningLine.style.top = 'calc(100% - 2rem)';
            scanningLine.style.opacity = '0.8';
          }, 100);
        }, 2000);
      }
    }

    /**
     * Stop scanning line animation
     */
  }, {
    key: "stopScanningAnimation",
    value: function stopScanningAnimation() {
      if (this.scanningInterval) {
        clearInterval(this.scanningInterval);
        this.scanningInterval = null;
      }
      var scanningLine = document.getElementById('scanning-line');
      if (scanningLine) {
        scanningLine.style.opacity = '0';
      }
    }

    /**
     * Check camera permission
     */
  }, {
    key: "checkCameraPermission",
    value: (function () {
      var _checkCameraPermission = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee2() {
        var stream, _t2;
        return _regenerator().w(function (_context2) {
          while (1) switch (_context2.p = _context2.n) {
            case 0:
              _context2.p = 0;
              _context2.n = 1;
              return navigator.mediaDevices.getUserMedia({
                video: {
                  facingMode: 'environment' // Use back camera on mobile
                }
              });
            case 1:
              stream = _context2.v;
              // Stop the stream immediately as we just wanted to check permission
              stream.getTracks().forEach(function (track) {
                return track.stop();
              });
              return _context2.a(2, true);
            case 2:
              _context2.p = 2;
              _t2 = _context2.v;
              return _context2.a(2, false);
          }
        }, _callee2, null, [[0, 2]]);
      }));
      function checkCameraPermission() {
        return _checkCameraPermission.apply(this, arguments);
      }
      return checkCameraPermission;
    }()
    /**
     * Request camera permission
     */
    )
  }, {
    key: "requestCameraPermission",
    value: (function () {
      var _requestCameraPermission = _asyncToGenerator(/*#__PURE__*/_regenerator().m(function _callee3() {
        var statusElement, hasPermission, retryBtn, _retryBtn, _t3;
        return _regenerator().w(function (_context3) {
          while (1) switch (_context3.p = _context3.n) {
            case 0:
              statusElement = document.getElementById('qr-status');
              if (statusElement) {
                statusElement.innerHTML = "\n                <div class=\"flex items-center justify-center space-x-2\">\n                    <div class=\"animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600\"></div>\n                    <p class=\"text-blue-600 font-medium\">Requesting camera permission...</p>\n                </div>\n            ";
              }
              _context3.p = 1;
              _context3.n = 2;
              return this.checkCameraPermission();
            case 2:
              hasPermission = _context3.v;
              if (!hasPermission) {
                _context3.n = 4;
                break;
              }
              // Hide retry button
              retryBtn = document.getElementById('retry-camera');
              if (retryBtn) {
                retryBtn.classList.add('hidden');
              }

              // Try starting scanner again
              _context3.n = 3;
              return this.startScanner();
            case 3:
              _context3.n = 5;
              break;
            case 4:
              if (statusElement) {
                statusElement.innerHTML = "\n                        <div class=\"text-center\">\n                            <div class=\"flex items-center justify-center space-x-2 mb-2\">\n                                <svg class=\"h-5 w-5 text-red-500\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n                                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 19.5c-.77.833.192 2.5 1.732 2.5z\" />\n                                </svg>\n                                <p class=\"text-red-600 font-medium\">Camera Permission Denied</p>\n                            </div>\n                            <p class=\"text-gray-500 text-sm\">Please enable camera access in your browser settings</p>\n                        </div>\n                    ";
              }

              // Show retry button
              _retryBtn = document.getElementById('retry-camera');
              if (_retryBtn) {
                _retryBtn.classList.remove('hidden');
              }
            case 5:
              _context3.n = 7;
              break;
            case 6:
              _context3.p = 6;
              _t3 = _context3.v;
            case 7:
              return _context3.a(2);
          }
        }, _callee3, this, [[1, 6]]);
      }));
      function requestCameraPermission() {
        return _requestCameraPermission.apply(this, arguments);
      }
      return requestCameraPermission;
    }()
    /**
     * Stop the QR scanner
     */
    )
  }, {
    key: "stopScanner",
    value: function stopScanner() {
      // Stop scanning animation
      this.stopScanningAnimation();
      if (this.scanner) {
        this.scanner.stop();
        this.scanner.destroy();
        this.scanner = null;
      }
      this.isProcessing = false;
    }

    /**
     * Handle scan result
     */
  }, {
    key: "handleScanResult",
    value: function handleScanResult(qrCode) {
      var _this4 = this;
      // Prevent multiple processing
      if (this.isProcessing) {
        return;
      }
      this.isProcessing = true;

      // Stop scanner immediately
      this.stopScanner();

      // Show processing message
      var statusElement = document.getElementById('qr-status');
      if (statusElement) {
        statusElement.innerHTML = "\n                <div class=\"text-center\">\n                    <div class=\"flex items-center justify-center space-x-2 mb-2\">\n                        <div class=\"animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600\"></div>\n                        <p class=\"text-blue-600 font-medium\">Processing QR Code...</p>\n                    </div>\n                    <div class=\"bg-blue-50 border border-blue-200 rounded-lg p-2\">\n                        <p class=\"text-xs text-blue-700 font-mono\">".concat(qrCode, "</p>\n                    </div>\n                </div>\n            ");
      }

      // Call backend handler
      if (window.qrBackendHandler && typeof window.qrBackendHandler.handleQRScanResult === 'function') {
        window.qrBackendHandler.handleQRScanResult(qrCode,
        // Success callback
        function (result) {
          _this4.closeModal();
        },
        // Error callback
        function (error) {
          _this4.closeModal();
        });
      } else {
        this.closeModal();
      }
    }
  }]);
}(); // Make the class available globally
window.QRScanner = QRScanner;
})();

/******/ })()
;