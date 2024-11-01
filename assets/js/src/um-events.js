/*! Magnific Popup - v1.1.0 - 2016-02-20
* http://dimsemenov.com/plugins/magnific-popup/
* Copyright (c) 2016 Dmitry Semenov; */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof exports?require("jquery"):window.jQuery||window.Zepto)}(function(a){var b,c,d,e,f,g,h="Close",i="BeforeClose",j="AfterClose",k="BeforeAppend",l="MarkupParse",m="Open",n="Change",o="mfp",p="."+o,q="mfp-ready",r="mfp-removing",s="mfp-prevent-close",t=function(){},u=!!window.jQuery,v=a(window),w=function(a,c){b.ev.on(o+a+p,c)},x=function(b,c,d,e){var f=document.createElement("div");return f.className="mfp-"+b,d&&(f.innerHTML=d),e?c&&c.appendChild(f):(f=a(f),c&&f.appendTo(c)),f},y=function(c,d){b.ev.triggerHandler(o+c,d),b.st.callbacks&&(c=c.charAt(0).toLowerCase()+c.slice(1),b.st.callbacks[c]&&b.st.callbacks[c].apply(b,a.isArray(d)?d:[d]))},z=function(c){return c===g&&b.currTemplate.closeBtn||(b.currTemplate.closeBtn=a(b.st.closeMarkup.replace("%title%",b.st.tClose)),g=c),b.currTemplate.closeBtn},A=function(){a.magnificPopup.instance||(b=new t,b.init(),a.magnificPopup.instance=b)},B=function(){var a=document.createElement("p").style,b=["ms","O","Moz","Webkit"];if(void 0!==a.transition)return!0;for(;b.length;)if(b.pop()+"Transition"in a)return!0;return!1};t.prototype={constructor:t,init:function(){var c=navigator.appVersion;b.isLowIE=b.isIE8=document.all&&!document.addEventListener,b.isAndroid=/android/gi.test(c),b.isIOS=/iphone|ipad|ipod/gi.test(c),b.supportsTransition=B(),b.probablyMobile=b.isAndroid||b.isIOS||/(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent),d=a(document),b.popupsCache={}},open:function(c){var e;if(c.isObj===!1){b.items=c.items.toArray(),b.index=0;var g,h=c.items;for(e=0;e<h.length;e++)if(g=h[e],g.parsed&&(g=g.el[0]),g===c.el[0]){b.index=e;break}}else b.items=a.isArray(c.items)?c.items:[c.items],b.index=c.index||0;if(b.isOpen)return void b.updateItemHTML();b.types=[],f="",c.mainEl&&c.mainEl.length?b.ev=c.mainEl.eq(0):b.ev=d,c.key?(b.popupsCache[c.key]||(b.popupsCache[c.key]={}),b.currTemplate=b.popupsCache[c.key]):b.currTemplate={},b.st=a.extend(!0,{},a.magnificPopup.defaults,c),b.fixedContentPos="auto"===b.st.fixedContentPos?!b.probablyMobile:b.st.fixedContentPos,b.st.modal&&(b.st.closeOnContentClick=!1,b.st.closeOnBgClick=!1,b.st.showCloseBtn=!1,b.st.enableEscapeKey=!1),b.bgOverlay||(b.bgOverlay=x("bg").on("click"+p,function(){b.close()}),b.wrap=x("wrap").attr("tabindex",-1).on("click"+p,function(a){b._checkIfClose(a.target)&&b.close()}),b.container=x("container",b.wrap)),b.contentContainer=x("content"),b.st.preloader&&(b.preloader=x("preloader",b.container,b.st.tLoading));var i=a.magnificPopup.modules;for(e=0;e<i.length;e++){var j=i[e];j=j.charAt(0).toUpperCase()+j.slice(1),b["init"+j].call(b)}y("BeforeOpen"),b.st.showCloseBtn&&(b.st.closeBtnInside?(w(l,function(a,b,c,d){c.close_replaceWith=z(d.type)}),f+=" mfp-close-btn-in"):b.wrap.append(z())),b.st.alignTop&&(f+=" mfp-align-top"),b.fixedContentPos?b.wrap.css({overflow:b.st.overflowY,overflowX:"hidden",overflowY:b.st.overflowY}):b.wrap.css({top:v.scrollTop(),position:"absolute"}),(b.st.fixedBgPos===!1||"auto"===b.st.fixedBgPos&&!b.fixedContentPos)&&b.bgOverlay.css({height:d.height(),position:"absolute"}),b.st.enableEscapeKey&&d.on("keyup"+p,function(a){27===a.keyCode&&b.close()}),v.on("resize"+p,function(){b.updateSize()}),b.st.closeOnContentClick||(f+=" mfp-auto-cursor"),f&&b.wrap.addClass(f);var k=b.wH=v.height(),n={};if(b.fixedContentPos&&b._hasScrollBar(k)){var o=b._getScrollbarSize();o&&(n.marginRight=o)}b.fixedContentPos&&(b.isIE7?a("body, html").css("overflow","hidden"):n.overflow="hidden");var r=b.st.mainClass;return b.isIE7&&(r+=" mfp-ie7"),r&&b._addClassToMFP(r),b.updateItemHTML(),y("BuildControls"),a("html").css(n),b.bgOverlay.add(b.wrap).prependTo(b.st.prependTo||a(document.body)),b._lastFocusedEl=document.activeElement,setTimeout(function(){b.content?(b._addClassToMFP(q),b._setFocus()):b.bgOverlay.addClass(q),d.on("focusin"+p,b._onFocusIn)},16),b.isOpen=!0,b.updateSize(k),y(m),c},close:function(){b.isOpen&&(y(i),b.isOpen=!1,b.st.removalDelay&&!b.isLowIE&&b.supportsTransition?(b._addClassToMFP(r),setTimeout(function(){b._close()},b.st.removalDelay)):b._close())},_close:function(){y(h);var c=r+" "+q+" ";if(b.bgOverlay.detach(),b.wrap.detach(),b.container.empty(),b.st.mainClass&&(c+=b.st.mainClass+" "),b._removeClassFromMFP(c),b.fixedContentPos){var e={marginRight:""};b.isIE7?a("body, html").css("overflow",""):e.overflow="",a("html").css(e)}d.off("keyup"+p+" focusin"+p),b.ev.off(p),b.wrap.attr("class","mfp-wrap").removeAttr("style"),b.bgOverlay.attr("class","mfp-bg"),b.container.attr("class","mfp-container"),!b.st.showCloseBtn||b.st.closeBtnInside&&b.currTemplate[b.currItem.type]!==!0||b.currTemplate.closeBtn&&b.currTemplate.closeBtn.detach(),b.st.autoFocusLast&&b._lastFocusedEl&&a(b._lastFocusedEl).focus(),b.currItem=null,b.content=null,b.currTemplate=null,b.prevHeight=0,y(j)},updateSize:function(a){if(b.isIOS){var c=document.documentElement.clientWidth/window.innerWidth,d=window.innerHeight*c;b.wrap.css("height",d),b.wH=d}else b.wH=a||v.height();b.fixedContentPos||b.wrap.css("height",b.wH),y("Resize")},updateItemHTML:function(){var c=b.items[b.index];b.contentContainer.detach(),b.content&&b.content.detach(),c.parsed||(c=b.parseEl(b.index));var d=c.type;if(y("BeforeChange",[b.currItem?b.currItem.type:"",d]),b.currItem=c,!b.currTemplate[d]){var f=b.st[d]?b.st[d].markup:!1;y("FirstMarkupParse",f),f?b.currTemplate[d]=a(f):b.currTemplate[d]=!0}e&&e!==c.type&&b.container.removeClass("mfp-"+e+"-holder");var g=b["get"+d.charAt(0).toUpperCase()+d.slice(1)](c,b.currTemplate[d]);b.appendContent(g,d),c.preloaded=!0,y(n,c),e=c.type,b.container.prepend(b.contentContainer),y("AfterChange")},appendContent:function(a,c){b.content=a,a?b.st.showCloseBtn&&b.st.closeBtnInside&&b.currTemplate[c]===!0?b.content.find(".mfp-close").length||b.content.append(z()):b.content=a:b.content="",y(k),b.container.addClass("mfp-"+c+"-holder"),b.contentContainer.append(b.content)},parseEl:function(c){var d,e=b.items[c];if(e.tagName?e={el:a(e)}:(d=e.type,e={data:e,src:e.src}),e.el){for(var f=b.types,g=0;g<f.length;g++)if(e.el.hasClass("mfp-"+f[g])){d=f[g];break}e.src=e.el.attr("data-mfp-src"),e.src||(e.src=e.el.attr("href"))}return e.type=d||b.st.type||"inline",e.index=c,e.parsed=!0,b.items[c]=e,y("ElementParse",e),b.items[c]},addGroup:function(a,c){var d=function(d){d.mfpEl=this,b._openClick(d,a,c)};c||(c={});var e="click.magnificPopup";c.mainEl=a,c.items?(c.isObj=!0,a.off(e).on(e,d)):(c.isObj=!1,c.delegate?a.off(e).on(e,c.delegate,d):(c.items=a,a.off(e).on(e,d)))},_openClick:function(c,d,e){var f=void 0!==e.midClick?e.midClick:a.magnificPopup.defaults.midClick;if(f||!(2===c.which||c.ctrlKey||c.metaKey||c.altKey||c.shiftKey)){var g=void 0!==e.disableOn?e.disableOn:a.magnificPopup.defaults.disableOn;if(g)if(a.isFunction(g)){if(!g.call(b))return!0}else if(v.width()<g)return!0;c.type&&(c.preventDefault(),b.isOpen&&c.stopPropagation()),e.el=a(c.mfpEl),e.delegate&&(e.items=d.find(e.delegate)),b.open(e)}},updateStatus:function(a,d){if(b.preloader){c!==a&&b.container.removeClass("mfp-s-"+c),d||"loading"!==a||(d=b.st.tLoading);var e={status:a,text:d};y("UpdateStatus",e),a=e.status,d=e.text,b.preloader.html(d),b.preloader.find("a").on("click",function(a){a.stopImmediatePropagation()}),b.container.addClass("mfp-s-"+a),c=a}},_checkIfClose:function(c){if(!a(c).hasClass(s)){var d=b.st.closeOnContentClick,e=b.st.closeOnBgClick;if(d&&e)return!0;if(!b.content||a(c).hasClass("mfp-close")||b.preloader&&c===b.preloader[0])return!0;if(c===b.content[0]||a.contains(b.content[0],c)){if(d)return!0}else if(e&&a.contains(document,c))return!0;return!1}},_addClassToMFP:function(a){b.bgOverlay.addClass(a),b.wrap.addClass(a)},_removeClassFromMFP:function(a){this.bgOverlay.removeClass(a),b.wrap.removeClass(a)},_hasScrollBar:function(a){return(b.isIE7?d.height():document.body.scrollHeight)>(a||v.height())},_setFocus:function(){(b.st.focus?b.content.find(b.st.focus).eq(0):b.wrap).focus()},_onFocusIn:function(c){return c.target===b.wrap[0]||a.contains(b.wrap[0],c.target)?void 0:(b._setFocus(),!1)},_parseMarkup:function(b,c,d){var e;d.data&&(c=a.extend(d.data,c)),y(l,[b,c,d]),a.each(c,function(c,d){if(void 0===d||d===!1)return!0;if(e=c.split("_"),e.length>1){var f=b.find(p+"-"+e[0]);if(f.length>0){var g=e[1];"replaceWith"===g?f[0]!==d[0]&&f.replaceWith(d):"img"===g?f.is("img")?f.attr("src",d):f.replaceWith(a("<img>").attr("src",d).attr("class",f.attr("class"))):f.attr(e[1],d)}}else b.find(p+"-"+c).html(d)})},_getScrollbarSize:function(){if(void 0===b.scrollbarSize){var a=document.createElement("div");a.style.cssText="width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;",document.body.appendChild(a),b.scrollbarSize=a.offsetWidth-a.clientWidth,document.body.removeChild(a)}return b.scrollbarSize}},a.magnificPopup={instance:null,proto:t.prototype,modules:[],open:function(b,c){return A(),b=b?a.extend(!0,{},b):{},b.isObj=!0,b.index=c||0,this.instance.open(b)},close:function(){return a.magnificPopup.instance&&a.magnificPopup.instance.close()},registerModule:function(b,c){c.options&&(a.magnificPopup.defaults[b]=c.options),a.extend(this.proto,c.proto),this.modules.push(b)},defaults:{disableOn:0,key:null,midClick:!1,mainClass:"",preloader:!0,focus:"",closeOnContentClick:!1,closeOnBgClick:!0,closeBtnInside:!0,showCloseBtn:!0,enableEscapeKey:!0,modal:!1,alignTop:!1,removalDelay:0,prependTo:null,fixedContentPos:"auto",fixedBgPos:"auto",overflowY:"auto",closeMarkup:'<button title="%title%" type="button" class="mfp-close">&#215;</button>',tClose:"Close (Esc)",tLoading:"Loading...",autoFocusLast:!0}},a.fn.magnificPopup=function(c){A();var d=a(this);if("string"==typeof c)if("open"===c){var e,f=u?d.data("magnificPopup"):d[0].magnificPopup,g=parseInt(arguments[1],10)||0;f.items?e=f.items[g]:(e=d,f.delegate&&(e=e.find(f.delegate)),e=e.eq(g)),b._openClick({mfpEl:e},d,f)}else b.isOpen&&b[c].apply(b,Array.prototype.slice.call(arguments,1));else c=a.extend(!0,{},c),u?d.data("magnificPopup",c):d[0].magnificPopup=c,b.addGroup(d,c);return d};var C,D,E,F="inline",G=function(){E&&(D.after(E.addClass(C)).detach(),E=null)};a.magnificPopup.registerModule(F,{options:{hiddenClass:"hide",markup:"",tNotFound:"Content not found"},proto:{initInline:function(){b.types.push(F),w(h+"."+F,function(){G()})},getInline:function(c,d){if(G(),c.src){var e=b.st.inline,f=a(c.src);if(f.length){var g=f[0].parentNode;g&&g.tagName&&(D||(C=e.hiddenClass,D=x(C),C="mfp-"+C),E=f.after(D).detach().removeClass(C)),b.updateStatus("ready")}else b.updateStatus("error",e.tNotFound),f=a("<div>");return c.inlineElement=f,f}return b.updateStatus("ready"),b._parseMarkup(d,{},c),d}}});var H,I="ajax",J=function(){H&&a(document.body).removeClass(H)},K=function(){J(),b.req&&b.req.abort()};a.magnificPopup.registerModule(I,{options:{settings:null,cursor:"mfp-ajax-cur",tError:'<a href="%url%">The content</a> could not be loaded.'},proto:{initAjax:function(){b.types.push(I),H=b.st.ajax.cursor,w(h+"."+I,K),w("BeforeChange."+I,K)},getAjax:function(c){H&&a(document.body).addClass(H),b.updateStatus("loading");var d=a.extend({url:c.src,success:function(d,e,f){var g={data:d,xhr:f};y("ParseAjax",g),b.appendContent(a(g.data),I),c.finished=!0,J(),b._setFocus(),setTimeout(function(){b.wrap.addClass(q)},16),b.updateStatus("ready"),y("AjaxContentAdded")},error:function(){J(),c.finished=c.loadError=!0,b.updateStatus("error",b.st.ajax.tError.replace("%url%",c.src))}},b.st.ajax.settings);return b.req=a.ajax(d),""}}});var L,M=function(c){if(c.data&&void 0!==c.data.title)return c.data.title;var d=b.st.image.titleSrc;if(d){if(a.isFunction(d))return d.call(b,c);if(c.el)return c.el.attr(d)||""}return""};a.magnificPopup.registerModule("image",{options:{markup:'<div class="mfp-figure"><div class="mfp-close"></div><figure><div class="mfp-img"></div><figcaption><div class="mfp-bottom-bar"><div class="mfp-title"></div><div class="mfp-counter"></div></div></figcaption></figure></div>',cursor:"mfp-zoom-out-cur",titleSrc:"title",verticalFit:!0,tError:'<a href="%url%">The image</a> could not be loaded.'},proto:{initImage:function(){var c=b.st.image,d=".image";b.types.push("image"),w(m+d,function(){"image"===b.currItem.type&&c.cursor&&a(document.body).addClass(c.cursor)}),w(h+d,function(){c.cursor&&a(document.body).removeClass(c.cursor),v.off("resize"+p)}),w("Resize"+d,b.resizeImage),b.isLowIE&&w("AfterChange",b.resizeImage)},resizeImage:function(){var a=b.currItem;if(a&&a.img&&b.st.image.verticalFit){var c=0;b.isLowIE&&(c=parseInt(a.img.css("padding-top"),10)+parseInt(a.img.css("padding-bottom"),10)),a.img.css("max-height",b.wH-c)}},_onImageHasSize:function(a){a.img&&(a.hasSize=!0,L&&clearInterval(L),a.isCheckingImgSize=!1,y("ImageHasSize",a),a.imgHidden&&(b.content&&b.content.removeClass("mfp-loading"),a.imgHidden=!1))},findImageSize:function(a){var c=0,d=a.img[0],e=function(f){L&&clearInterval(L),L=setInterval(function(){return d.naturalWidth>0?void b._onImageHasSize(a):(c>200&&clearInterval(L),c++,void(3===c?e(10):40===c?e(50):100===c&&e(500)))},f)};e(1)},getImage:function(c,d){var e=0,f=function(){c&&(c.img[0].complete?(c.img.off(".mfploader"),c===b.currItem&&(b._onImageHasSize(c),b.updateStatus("ready")),c.hasSize=!0,c.loaded=!0,y("ImageLoadComplete")):(e++,200>e?setTimeout(f,100):g()))},g=function(){c&&(c.img.off(".mfploader"),c===b.currItem&&(b._onImageHasSize(c),b.updateStatus("error",h.tError.replace("%url%",c.src))),c.hasSize=!0,c.loaded=!0,c.loadError=!0)},h=b.st.image,i=d.find(".mfp-img");if(i.length){var j=document.createElement("img");j.className="mfp-img",c.el&&c.el.find("img").length&&(j.alt=c.el.find("img").attr("alt")),c.img=a(j).on("load.mfploader",f).on("error.mfploader",g),j.src=c.src,i.is("img")&&(c.img=c.img.clone()),j=c.img[0],j.naturalWidth>0?c.hasSize=!0:j.width||(c.hasSize=!1)}return b._parseMarkup(d,{title:M(c),img_replaceWith:c.img},c),b.resizeImage(),c.hasSize?(L&&clearInterval(L),c.loadError?(d.addClass("mfp-loading"),b.updateStatus("error",h.tError.replace("%url%",c.src))):(d.removeClass("mfp-loading"),b.updateStatus("ready")),d):(b.updateStatus("loading"),c.loading=!0,c.hasSize||(c.imgHidden=!0,d.addClass("mfp-loading"),b.findImageSize(c)),d)}}});var N,O=function(){return void 0===N&&(N=void 0!==document.createElement("p").style.MozTransform),N};a.magnificPopup.registerModule("zoom",{options:{enabled:!1,easing:"ease-in-out",duration:300,opener:function(a){return a.is("img")?a:a.find("img")}},proto:{initZoom:function(){var a,c=b.st.zoom,d=".zoom";if(c.enabled&&b.supportsTransition){var e,f,g=c.duration,j=function(a){var b=a.clone().removeAttr("style").removeAttr("class").addClass("mfp-animated-image"),d="all "+c.duration/1e3+"s "+c.easing,e={position:"fixed",zIndex:9999,left:0,top:0,"-webkit-backface-visibility":"hidden"},f="transition";return e["-webkit-"+f]=e["-moz-"+f]=e["-o-"+f]=e[f]=d,b.css(e),b},k=function(){b.content.css("visibility","visible")};w("BuildControls"+d,function(){if(b._allowZoom()){if(clearTimeout(e),b.content.css("visibility","hidden"),a=b._getItemToZoom(),!a)return void k();f=j(a),f.css(b._getOffset()),b.wrap.append(f),e=setTimeout(function(){f.css(b._getOffset(!0)),e=setTimeout(function(){k(),setTimeout(function(){f.remove(),a=f=null,y("ZoomAnimationEnded")},16)},g)},16)}}),w(i+d,function(){if(b._allowZoom()){if(clearTimeout(e),b.st.removalDelay=g,!a){if(a=b._getItemToZoom(),!a)return;f=j(a)}f.css(b._getOffset(!0)),b.wrap.append(f),b.content.css("visibility","hidden"),setTimeout(function(){f.css(b._getOffset())},16)}}),w(h+d,function(){b._allowZoom()&&(k(),f&&f.remove(),a=null)})}},_allowZoom:function(){return"image"===b.currItem.type},_getItemToZoom:function(){return b.currItem.hasSize?b.currItem.img:!1},_getOffset:function(c){var d;d=c?b.currItem.img:b.st.zoom.opener(b.currItem.el||b.currItem);var e=d.offset(),f=parseInt(d.css("padding-top"),10),g=parseInt(d.css("padding-bottom"),10);e.top-=a(window).scrollTop()-f;var h={width:d.width(),height:(u?d.innerHeight():d[0].offsetHeight)-g-f};return O()?h["-moz-transform"]=h.transform="translate("+e.left+"px,"+e.top+"px)":(h.left=e.left,h.top=e.top),h}}});var P="iframe",Q="//about:blank",R=function(a){if(b.currTemplate[P]){var c=b.currTemplate[P].find("iframe");c.length&&(a||(c[0].src=Q),b.isIE8&&c.css("display",a?"block":"none"))}};a.magnificPopup.registerModule(P,{options:{markup:'<div class="mfp-iframe-scaler"><div class="mfp-close"></div><iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe></div>',srcAction:"iframe_src",patterns:{youtube:{index:"youtube.com",id:"v=",src:"//www.youtube.com/embed/%id%?autoplay=1"},vimeo:{index:"vimeo.com/",id:"/",src:"//player.vimeo.com/video/%id%?autoplay=1"},gmaps:{index:"//maps.google.",src:"%id%&output=embed"}}},proto:{initIframe:function(){b.types.push(P),w("BeforeChange",function(a,b,c){b!==c&&(b===P?R():c===P&&R(!0))}),w(h+"."+P,function(){R()})},getIframe:function(c,d){var e=c.src,f=b.st.iframe;a.each(f.patterns,function(){return e.indexOf(this.index)>-1?(this.id&&(e="string"==typeof this.id?e.substr(e.lastIndexOf(this.id)+this.id.length,e.length):this.id.call(this,e)),e=this.src.replace("%id%",e),!1):void 0});var g={};return f.srcAction&&(g[f.srcAction]=e),b._parseMarkup(d,g,c),b.updateStatus("ready"),d}}});var S=function(a){var c=b.items.length;return a>c-1?a-c:0>a?c+a:a},T=function(a,b,c){return a.replace(/%curr%/gi,b+1).replace(/%total%/gi,c)};a.magnificPopup.registerModule("gallery",{options:{enabled:!1,arrowMarkup:'<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',preload:[0,2],navigateByImgClick:!0,arrows:!0,tPrev:"Previous (Left arrow key)",tNext:"Next (Right arrow key)",tCounter:"%curr% of %total%"},proto:{initGallery:function(){var c=b.st.gallery,e=".mfp-gallery";return b.direction=!0,c&&c.enabled?(f+=" mfp-gallery",w(m+e,function(){c.navigateByImgClick&&b.wrap.on("click"+e,".mfp-img",function(){return b.items.length>1?(b.next(),!1):void 0}),d.on("keydown"+e,function(a){37===a.keyCode?b.prev():39===a.keyCode&&b.next()})}),w("UpdateStatus"+e,function(a,c){c.text&&(c.text=T(c.text,b.currItem.index,b.items.length))}),w(l+e,function(a,d,e,f){var g=b.items.length;e.counter=g>1?T(c.tCounter,f.index,g):""}),w("BuildControls"+e,function(){if(b.items.length>1&&c.arrows&&!b.arrowLeft){var d=c.arrowMarkup,e=b.arrowLeft=a(d.replace(/%title%/gi,c.tPrev).replace(/%dir%/gi,"left")).addClass(s),f=b.arrowRight=a(d.replace(/%title%/gi,c.tNext).replace(/%dir%/gi,"right")).addClass(s);e.click(function(){b.prev()}),f.click(function(){b.next()}),b.container.append(e.add(f))}}),w(n+e,function(){b._preloadTimeout&&clearTimeout(b._preloadTimeout),b._preloadTimeout=setTimeout(function(){b.preloadNearbyImages(),b._preloadTimeout=null},16)}),void w(h+e,function(){d.off(e),b.wrap.off("click"+e),b.arrowRight=b.arrowLeft=null})):!1},next:function(){b.direction=!0,b.index=S(b.index+1),b.updateItemHTML()},prev:function(){b.direction=!1,b.index=S(b.index-1),b.updateItemHTML()},goTo:function(a){b.direction=a>=b.index,b.index=a,b.updateItemHTML()},preloadNearbyImages:function(){var a,c=b.st.gallery.preload,d=Math.min(c[0],b.items.length),e=Math.min(c[1],b.items.length);for(a=1;a<=(b.direction?e:d);a++)b._preloadItem(b.index+a);for(a=1;a<=(b.direction?d:e);a++)b._preloadItem(b.index-a)},_preloadItem:function(c){if(c=S(c),!b.items[c].preloaded){var d=b.items[c];d.parsed||(d=b.parseEl(c)),y("LazyLoad",d),"image"===d.type&&(d.img=a('<img class="mfp-img" />').on("load.mfploader",function(){d.hasSize=!0}).on("error.mfploader",function(){d.hasSize=!0,d.loadError=!0,y("LazyLoadError",d)}).attr("src",d.src)),d.preloaded=!0}}}});var U="retina";a.magnificPopup.registerModule(U,{options:{replaceSrc:function(a){return a.src.replace(/\.\w+$/,function(a){return"@2x"+a})},ratio:1},proto:{initRetina:function(){if(window.devicePixelRatio>1){var a=b.st.retina,c=a.ratio;c=isNaN(c)?c():c,c>1&&(w("ImageHasSize."+U,function(a,b){b.img.css({"max-width":b.img[0].naturalWidth/c,width:"100%"})}),w("ElementParse."+U,function(b,d){d.src=a.replaceSrc(d,c)}))}}}}),A()});

/*Timepicker */
!function(e){"object"==typeof module&&"object"==typeof module.exports?e(require("jquery"),window,document):"undefined"!=typeof jQuery&&e(jQuery,window,document)}(function(e,t,i,n){!function(){function t(e,t,i){return new Array(i+1-e.length).join(t)+e}function n(){if(1===arguments.length){var t=arguments[0];return"string"==typeof t&&(t=e.fn.timepicker.parseTime(t)),new Date(0,0,0,t.getHours(),t.getMinutes(),t.getSeconds())}return 3===arguments.length?new Date(0,0,0,arguments[0],arguments[1],arguments[2]):2===arguments.length?new Date(0,0,0,arguments[0],arguments[1],0):new Date(0,0,0)}e.TimePicker=function(){var t=this;t.container=e(".ui-timepicker-container"),t.ui=t.container.find(".ui-timepicker"),0===t.container.length&&(t.container=e("<div></div>").addClass("ui-timepicker-container").addClass("ui-timepicker-hidden ui-helper-hidden").appendTo("body").hide(),t.ui=e("<div></div>").addClass("ui-timepicker").addClass("ui-widget ui-widget-content ui-menu").addClass("ui-corner-all").appendTo(t.container),t.viewport=e("<ul></ul>").addClass("ui-timepicker-viewport").appendTo(t.ui),e.fn.jquery>="1.4.2"&&t.ui.delegate("a","mouseenter.timepicker",function(){t.activate(!1,e(this).parent())}).delegate("a","mouseleave.timepicker",function(){t.deactivate(!1)}).delegate("a","click.timepicker",function(i){i.preventDefault(),t.select(!1,e(this).parent())}))},e.TimePicker.count=0,e.TimePicker.instance=function(){return e.TimePicker._instance||(e.TimePicker._instance=new e.TimePicker),e.TimePicker._instance},e.TimePicker.prototype={keyCode:{ALT:18,BLOQ_MAYUS:20,CTRL:17,DOWN:40,END:35,ENTER:13,HOME:36,LEFT:37,NUMPAD_ENTER:108,PAGE_DOWN:34,PAGE_UP:33,RIGHT:39,SHIFT:16,TAB:9,UP:38},_items:function(t,i){var r,a,o=this,s=e("<ul></ul>"),u=null;for(-1===t.options.timeFormat.indexOf("m")&&t.options.interval%60!==0&&(t.options.interval=60*Math.max(Math.round(t.options.interval/60),1)),r=i?n(i):t.options.startTime?n(t.options.startTime):n(t.options.startHour,t.options.startMinutes),a=new Date(r.getTime()+864e5);a>r;)o._isValidTime(t,r)&&(u=e("<li>").addClass("ui-menu-item").appendTo(s),e("<a>").addClass("ui-corner-all").text(e.fn.timepicker.formatTime(t.options.timeFormat,r)).appendTo(u),u.data("time-value",r)),r=new Date(r.getTime()+60*t.options.interval*1e3);return s.children()},_isValidTime:function(e,t){var i=null,r=null;return t=n(t),null!==e.options.minTime?i=n(e.options.minTime):(null!==e.options.minHour||null!==e.options.minMinutes)&&(i=n(e.options.minHour,e.options.minMinutes)),null!==e.options.maxTime?r=n(e.options.maxTime):(null!==e.options.maxHour||null!==e.options.maxMinutes)&&(r=n(e.options.maxHour,e.options.maxMinutes)),null!==i&&null!==r?t>=i&&r>=t:null!==i?t>=i:null!==r?r>=t:!0},_hasScroll:function(){var e="undefined"!=typeof this.ui.prop?"prop":"attr";return this.ui.height()<this.ui[e]("scrollHeight")},_move:function(e,t,i){var n=this;if(n.closed()&&n.open(e),!n.active)return void n.activate(e,n.viewport.children(i));var r=n.active[t+"All"](".ui-menu-item").eq(0);r.length?n.activate(e,r):n.activate(e,n.viewport.children(i))},register:function(t,i){var n=this,r={};r.element=e(t),r.element.data("TimePicker")||(r.options=e.metadata?e.extend({},i,r.element.metadata()):e.extend({},i),r.widget=n,e.extend(r,{next:function(){return n.next(r)},previous:function(){return n.previous(r)},first:function(){return n.first(r)},last:function(){return n.last(r)},selected:function(){return n.selected(r)},open:function(){return n.open(r)},close:function(){return n.close(r)},closed:function(){return n.closed(r)},destroy:function(){return n.destroy(r)},parse:function(e){return n.parse(r,e)},format:function(e,t){return n.format(r,e,t)},getTime:function(){return n.getTime(r)},setTime:function(e,t){return n.setTime(r,e,t)},option:function(e,t){return n.option(r,e,t)}}),n._setDefaultTime(r),n._addInputEventsHandlers(r),r.element.data("TimePicker",r))},_setDefaultTime:function(t){"now"===t.options.defaultTime?t.setTime(n(new Date)):t.options.defaultTime&&t.options.defaultTime.getFullYear?t.setTime(n(t.options.defaultTime)):t.options.defaultTime&&t.setTime(e.fn.timepicker.parseTime(t.options.defaultTime))},_addInputEventsHandlers:function(t){var i=this;t.element.bind("keydown.timepicker",function(e){switch(e.which||e.keyCode){case i.keyCode.ENTER:case i.keyCode.NUMPAD_ENTER:e.preventDefault(),i.closed()?t.element.trigger("change.timepicker"):i.select(t,i.active);break;case i.keyCode.UP:t.previous();break;case i.keyCode.DOWN:t.next();break;default:i.closed()||t.close(!0)}}).bind("focus.timepicker",function(){t.open()}).bind("blur.timepicker",function(){setTimeout(function(){t.element.data("timepicker-user-clicked-outside")&&t.close()})}).bind("change.timepicker",function(){t.closed()&&t.setTime(e.fn.timepicker.parseTime(t.element.val()))})},select:function(t,i){var n=this,r=t===!1?n.instance:t;n.setTime(r,e.fn.timepicker.parseTime(i.children("a").text())),n.close(r,!0)},activate:function(e,t){var i=this,n=e===!1?i.instance:e;if(n===i.instance){if(i.deactivate(),i._hasScroll()){var r=t.offset().top-i.ui.offset().top,a=i.ui.scrollTop(),o=i.ui.height();0>r?i.ui.scrollTop(a+r):r>=o&&i.ui.scrollTop(a+r-o+t.height())}i.active=t.eq(0).children("a").addClass("ui-state-hover").attr("id","ui-active-item").end()}},deactivate:function(){var e=this;e.active&&(e.active.children("a").removeClass("ui-state-hover").removeAttr("id"),e.active=null)},next:function(e){return(this.closed()||this.instance===e)&&this._move(e,"next",".ui-menu-item:first"),e.element},previous:function(e){return(this.closed()||this.instance===e)&&this._move(e,"prev",".ui-menu-item:last"),e.element},first:function(e){return this.instance===e?this.active&&0===this.active.prevAll(".ui-menu-item").length:!1},last:function(e){return this.instance===e?this.active&&0===this.active.nextAll(".ui-menu-item").length:!1},selected:function(e){return this.instance===e&&this.active?this.active:null},open:function(t){var n=this,r=t.getTime(),a=t.options.dynamic&&r;if(!t.options.dropdown)return t.element;switch(t.element.data("timepicker-event-namespace",Math.random()),e(i).bind("click.timepicker-"+t.element.data("timepicker-event-namespace"),function(e){t.element.get(0)===e.target?t.element.data("timepicker-user-clicked-outside",!1):t.element.data("timepicker-user-clicked-outside",!0).blur()}),(t.rebuild||!t.items||a)&&(t.items=n._items(t,a?r:null)),(t.rebuild||n.instance!==t||a)&&(e.fn.jquery<"1.4.2"?(n.viewport.children().remove(),n.viewport.append(t.items),n.viewport.find("a").bind("mouseover.timepicker",function(){n.activate(t,e(this).parent())}).bind("mouseout.timepicker",function(){n.deactivate(t)}).bind("click.timepicker",function(i){i.preventDefault(),n.select(t,e(this).parent())})):(n.viewport.children().detach(),n.viewport.append(t.items))),t.rebuild=!1,n.container.removeClass("ui-helper-hidden ui-timepicker-hidden ui-timepicker-standard ui-timepicker-corners").show(),t.options.theme){case"standard":n.container.addClass("ui-timepicker-standard");break;case"standard-rounded-corners":n.container.addClass("ui-timepicker-standard ui-timepicker-corners")}n.container.hasClass("ui-timepicker-no-scrollbar")||t.options.scrollbar||(n.container.addClass("ui-timepicker-no-scrollbar"),n.viewport.css({paddingRight:40}));var o=n.container.outerHeight()-n.container.height(),s=t.options.zindex?t.options.zindex:t.element.offsetParent().css("z-index"),u=t.element.offset();n.container.css({top:u.top+t.element.outerHeight(),left:u.left}),n.container.show(),n.container.css({left:t.element.offset().left,height:n.ui.outerHeight()+o,width:t.element.outerWidth(),zIndex:s,cursor:"default"});var c=n.container.width()-(n.ui.outerWidth()-n.ui.width());return n.ui.css({width:c}),n.viewport.css({width:c}),t.items.css({width:c}),n.instance=t,r?t.items.each(function(){var i,a=e(this);return i=e.fn.jquery<"1.4.2"?e.fn.timepicker.parseTime(a.find("a").text()):a.data("time-value"),i.getTime()===r.getTime()?(n.activate(t,a),!1):!0}):n.deactivate(t),t.element},close:function(t){var n=this;return n.instance===t&&(n.container.addClass("ui-helper-hidden ui-timepicker-hidden").hide(),n.ui.scrollTop(0),n.ui.children().removeClass("ui-state-hover")),e(i).unbind("click.timepicker-"+t.element.data("timepicker-event-namespace")),t.element},closed:function(){return this.ui.is(":hidden")},destroy:function(e){var t=this;return t.close(e,!0),e.element.unbind(".timepicker").data("TimePicker",null)},parse:function(t,i){return e.fn.timepicker.parseTime(i)},format:function(t,i,n){return n=n||t.options.timeFormat,e.fn.timepicker.formatTime(n,i)},getTime:function(t){var i=this,n=e.fn.timepicker.parseTime(t.element.val());return n instanceof Date&&!i._isValidTime(t,n)?null:n instanceof Date&&t.selectedTime?t.format(n)===t.format(t.selectedTime)?t.selectedTime:n:n instanceof Date?n:null},setTime:function(t,i,r){var a=this,o=t.selectedTime;if("string"==typeof i&&(i=t.parse(i)),i&&i.getMinutes&&a._isValidTime(t,i)){if(i=n(i),t.selectedTime=i,t.element.val(t.format(i,t.options.timeFormat)),r)return t}else t.selectedTime=null;return(null!==o||null!==t.selectedTime)&&(t.element.trigger("time-change",[i]),e.isFunction(t.options.change)&&t.options.change.apply(t.element,[i])),t.element},option:function(t,i,n){if("undefined"==typeof n)return t.options[i];var r,a,o=t.getTime();"string"==typeof i?(r={},r[i]=n):r=i,a=["minHour","minMinutes","minTime","maxHour","maxMinutes","maxTime","startHour","startMinutes","startTime","timeFormat","interval","dropdown"],e.each(r,function(i){t.options[i]=r[i],t.rebuild=t.rebuild||e.inArray(i,a)>-1}),t.rebuild&&t.setTime(o)}},e.TimePicker.defaults={timeFormat:"hh:mm p",minHour:null,minMinutes:null,minTime:null,maxHour:null,maxMinutes:null,maxTime:null,startHour:null,startMinutes:null,startTime:null,interval:30,dynamic:!0,theme:"standard",zindex:null,dropdown:!0,scrollbar:!1,change:function(){}},e.TimePicker.methods={chainable:["next","previous","open","close","destroy","setTime"]},e.fn.timepicker=function(t){if("string"==typeof t){var i,n,r=Array.prototype.slice.call(arguments,1);return i="option"===t&&arguments.length>2?"each":-1!==e.inArray(t,e.TimePicker.methods.chainable)?"each":"map",n=this[i](function(){var i=e(this),n=i.data("TimePicker");return"object"==typeof n?n[t].apply(n,r):void 0}),"map"===i&&1===this.length?e.makeArray(n).shift():"map"===i?e.makeArray(n):n}if(1===this.length&&this.data("TimePicker"))return this.data("TimePicker");var a=e.extend({},e.TimePicker.defaults,t);return this.each(function(){e.TimePicker.instance().register(this,a)})},e.fn.timepicker.formatTime=function(e,i){var n=i.getHours(),r=n%12,a=i.getMinutes(),o=i.getSeconds(),s={hh:t((0===r?12:r).toString(),"0",2),HH:t(n.toString(),"0",2),mm:t(a.toString(),"0",2),ss:t(o.toString(),"0",2),h:0===r?12:r,H:n,m:a,s:o,p:n>11?"PM":"AM"},u=e,c="";for(c in s)s.hasOwnProperty(c)&&(u=u.replace(new RegExp(c,"g"),s[c]));return u=u.replace(new RegExp("a","g"),n>11?"pm":"am")},e.fn.timepicker.parseTime=function(){var t=[[/^(\d+)$/,"$1"],[/^:(\d)$/,"$10"],[/^:(\d+)/,"$1"],[/^(\d):([7-9])$/,"0$10$2"],[/^(\d):(\d\d)$/,"$1$2"],[/^(\d):(\d{1,})$/,"0$1$20"],[/^(\d\d):([7-9])$/,"$10$2"],[/^(\d\d):(\d)$/,"$1$20"],[/^(\d\d):(\d*)$/,"$1$2"],[/^(\d{3,}):(\d)$/,"$10$2"],[/^(\d{3,}):(\d{2,})/,"$1$2"],[/^(\d):(\d):(\d)$/,"0$10$20$3"],[/^(\d{1,2}):(\d):(\d\d)/,"$10$2$3"]],i=t.length;return function(r){var a=n(new Date),o=!1,s=!1,u=!1,c=!1,l=!1;if("undefined"==typeof r||!r.toLowerCase)return null;r=r.toLowerCase(),o=/a/.test(r),s=o?!1:/p/.test(r),r=r.replace(/[^0-9:]/g,"").replace(/:+/g,":");for(var m=0;i>m;m+=1)if(t[m][0].test(r)){r=r.replace(t[m][0],t[m][1]);break}return r=r.replace(/:/g,""),1===r.length?u=r:2===r.length?u=r:3===r.length||5===r.length?(u=r.substr(0,1),c=r.substr(1,2),l=r.substr(3,2)):(4===r.length||r.length>5)&&(u=r.substr(0,2),c=r.substr(2,2),l=r.substr(4,2)),r.length>0&&r.length<5&&(r.length<3&&(c=0),l=0),u===!1||c===!1||l===!1?!1:(u=parseInt(u,10),c=parseInt(c,10),l=parseInt(l,10),o&&12===u?u=0:s&&12>u&&(u+=12),u>24?r.length>=6?e.fn.timepicker.parseTime(r.substr(0,5)):e.fn.timepicker.parseTime(r+"0"+(o?"a":"")+(s?"p":"")):(a.setHours(u,c,l),a))}}()}()});


function _um_event_delete( id ){
		jQuery.ajax({
			type: 'post',
			url: um_event_config.ajax_url,
			 data: {
				'action': 'um_event_delete',
				'id': id,
				'security': um_event_config.nonce
			},
			cache: false,
			success: function(response) {
				
			}
		});
	}
	function _um_event_readURL(input) {

		if (input.files && input.files[0]) {
			var reader = new FileReader();
	
			reader.onload = function (e) {
				jQuery('.um-event-image-bg').css({"background-image":'url('+ e.target.result +')'});
			}
	
			reader.readAsDataURL(input.files[0]);
		}
	}

	 function _um_event_isEmpty( el ){
		  return !jQuery.trim(jQuery(el).html())
	  }
	function _um_event_delete( id ){
		jQuery.ajax({
			type: 'post',
			url: um_event_config.ajax_url,
			data: {
				'action': 'um_event_delete',
				'id': id,
				'security': um_event_config.nonce
			},
			cache: false,
			success: function(response) {
				if(response.success === true){
					jQuery("#um-event-" + id).slideUp().remove();
					if( _um_event_isEmpty('.um-events-list') ){
						jQuery('.um-events-list').append( um_event_config.no_events_txt );
					}
				}
			}
		});
	}
	function _um_event_view( id ){
		var modal_id = '#um-event-modal';
		jQuery(modal_id).html('<div class="um-event-loader"><i class="fa fa-spin fa-spinner"></i></div>');
		jQuery.magnificPopup.open({
		  items: {
			src: modal_id
		  },
		  type: 'inline',
		  'mainClass': 'um-event-modal-wrapper',
		
		  // You may add options here, they're exactly the same as for $.fn.magnificPopup call
		  // Note that some settings that rely on click event (like disableOn or midClick) will not work here
		}, 0);
		jQuery.ajax({
			type: 'get',
			url: um_event_config.ajax_url,
			data: {
				'action': 'um_event_get_view',
				'id': id
			},
			success: function(response) {
				jQuery(modal_id).html(response);
			}
		});
	}
	function _um_event_form( id ){
		var modal_id = '#um-event-modal';
		jQuery(modal_id).html('<div class="um-event-loader"><i class="fa fa-spin fa-spinner"></i></div>');
		jQuery.magnificPopup.open({
		  items: {
			src: modal_id
		  },
		  type: 'inline',
		  'mainClass': 'um-event-modal-wrapper',
		
		  // You may add options here, they're exactly the same as for $.fn.magnificPopup call
		  // Note that some settings that rely on click event (like disableOn or midClick) will not work here
		}, 0);
		
		jQuery.ajax({
			type: 'get',
			url: um_event_config.ajax_url,
			data: {
				'action': 'um_event_get_form',
				'id': id
			},
			cache: false,
			success: function(response) {
				jQuery(modal_id).html(response);
				jQuery('.um-event-time').timepicker({ 
					timeFormat: 'h:mm:ss p',
					zindex: 999999 
				});
				
				jQuery('.um-event-date-input').Zebra_DatePicker({
					format: 'M d, Y',
					container: jQuery("#um_event_form"),
					show_icon: false,
				});
			}
		});
		

	}
jQuery(document).ready(function($) {

	jQuery(document).on("click", ".um-event-form,.um-event-edit-link", function(event){
		event.preventDefault();
		var id = $(this).data('id');
		_um_event_form( id );
	});
	jQuery(document).on("click", ".um-event-delete-link", function(event){
		event.preventDefault();
		var id = $(this).data('id');
		_um_event_delete( id );
	});
	$('.um-event-time').timepicker({ 
		timeFormat: 'h:mm:ss p',
		zindex: 999999 
	});

	jQuery( "#um-event-form-tabs" ).tabs();
	
	function split( val ) {
	  return val.split( /,\s*/ );
	}
	function extractLast( term ) {
	  return split( term ).pop();
	}
	var content;
	$( "#tags" ).autocomplete({
		minLength: 0,
		//classes: { 'ui-autocomplete': 'um-events-user-picker' },
		source: function( request, response ) {
			$.getJSON( um_event_config.get_users, {
				term: extractLast( request.term )
			}, response );
		},
		search: function() {
			var term = extractLast( this.value );
			if ( term.length < 3 ) {
				return false;
			}
		},
		focus: function( event, ui ) {
			return false;
		},
		select: function( event, ui ) {
			if ( ! jQuery( '#event-guest-'+ ui.item.id ).length ) {
				content = '<li id="event-guest-'+ ui.item.id +'">'+
						'<span class="um-event-avatar">'+
							'<img src="'+ ui.item.avatar +'" />'+
						'</span>'+
						'<span class="um-event-name">'+ ui.item.name +'</span>'+
						'<span class="um-event-remove"><a href="#" class="um-event-form-remove-user"><i class="um-faicon-times" aria-hidden="true"></i></a></span>'+
						'<input type="hidden" name="um_event_rsvp[]" value="' + ui.item.id + '" />'+
					'</li>';
				$( '.um-event-form-guest-list ul' ).append( content );
			}
			return false;
		}
	})
	.autocomplete( "instance" )._renderItem = function( ul, item ) {
		ul.addClass('um-events-user-picker');
		return $( "<li>" )
			.append( '<span class="um-event-avatar"><img src="'+ item.avatar +'" /></span><span class="um-event-name">'+ item.name +'</span>' )
			.appendTo( ul );
	};
	
	jQuery( document ).on( 'click', '.um-event-form-remove-user', function( e ) {
		e.preventDefault();
		jQuery(this).closest('li').hide().remove();
	});
	/*$('.um-event-date-input').Zebra_DatePicker({
		format: 'M d, Y',
		container: jQuery("#um_event_form,.um_events_meta_area"),
		show_icon: false,
	});*/


	$("#um_event_date_start").datepicker({
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onSelect: function(selected) {
			jQuery("#um_event_date_end").datepicker("option","minDate", selected)
		}
	});
	jQuery("#um_event_date_end").datepicker({ 
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onSelect: function(selected) {
			jQuery("#um_event_date_start").datepicker("option","maxDate", selected)
		}
	});

	jQuery('.um-event-date-input').datepicker();
	
	jQuery(document).on("click", "#um-event-add-end", function(event){
		event.preventDefault();
		$(this).hide();
		$('.um-event-end-date').slideDown();
	});
	jQuery(document).on("click", "#um-event-remove-end", function(event){
		event.preventDefault();
		$("#um-event-add-end").show();
		$('.um-event-end-date').slideUp();
	});
	if (typeof monthly !== 'undefined' && $.isFunction(monthly)) {
		jQuery('#um-event-calendar').monthly({
		  mode: 'event',
		  xmlUrl: um_event_config.events_feed
		});
	}
	jQuery(document).on("click", ".um-event-link", function(event){
		event.preventDefault();
		var eventid = $(this).data('eventid');
		_um_event_view( eventid );
	});
	jQuery(document).on("change", ".event__file", function(event){
		_um_event_readURL(this);
	});
	jQuery(document).on("click", ".um-event-guest-action-button", function(event){
		event.preventDefault();
		var obj     = $(this);
		var eventid = $(this).closest('ul').data( 'event_id' );
		var choice  = $(this).data( 'action' );
		jQuery.ajax({
			type: 'post',
			url: um_event_config.ajax_url,
			data: {
				'action': 'um_event_guest_action',
				'user_choice': choice,
				'event_id': eventid,
				'security': um_event_config.nonce
			},
			cache: false,
			success: function(response) {
				if ( response.success === true ) {
					obj.closest('ul').find('a').removeClass('um-event-button-active');
					obj.addClass('um-event-button-active');

					obj.closest('.um-events-guest-actions').find( '.um-events-guest-count').text( response.data.attendance_text );
				}
			}
		});
	});
	jQuery(document).on("submit", "#um_event_form", function(event){
		event.preventDefault();
		$('.um-event-form-errors').slideUp();
		//var formData = $(this).serializeArray();
		var formData = new FormData($(this)[0]);
		formData.append('action', 'um_events_save');
		jQuery.ajax({
			type: 'post',
			url: um_event_config.ajax_url,
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function(response) {
				if(response.error_message){
					$('.um-event-form-message').removeClass('um-event-form-success').addClass('um-event-form-errors').html(response.error_message).slideDown();
					$("html, body").animate({ scrollTop: 0 }, "slow");
					return false;
				}
				if(response.id){
					$('.um-event-form-message').addClass('um-event-form-success').removeClass('um-event-form-errors').html(response.message).slideDown();
					$('#um_event_id').val(response.id);
					$("html, body").animate({ scrollTop: 0 }, "slow");
				}
				
			}
		});
	});
});