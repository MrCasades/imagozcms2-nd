
  </main>

  <footer>
	<div class="footer">
		<p><a href="<?php echo '//'.MAIN_URL;?>/sitemap/">Карта сайта</a>
			<a href="<?php echo '//'.MAIN_URL;?>/cooperation/">Сотрудничество</a>
			<a href="<?php echo '//'.MAIN_URL;?>/promotion/">Промоушен</a>
		</p>
		<p>Copyright © 2019-2021 MrCasades. All rights reserved.</p>
	</div>
	<div class="counts">
		  <div>
			<!-- Rating@Mail.ru counter -->
			
			<script type="text/javascript">//<![CDATA[
			
			(function(w,n,d,r,s){d.write('<div><a href="http://top.mail.ru/jump?from=2339008"><img src="'+
			
			('https:'==d.location.protocol?'https:':'http:')+'//top-fwz1.mail.ru/counter?id=2339008;t=246;js=13'+
			
			((r=d.referrer)?';r='+escape(r):'')+((s=w.screen)?';s='+s.width+'*'+s.height:'')+';_='+Math.random()+
			
			'" style="border:0;" height="31" width="88" alt="Рейтинг@Mail.ru" /><\/a><\/div>');})(window,navigator,document);//]]>
			
			</script><noscript><div><a href="http://top.mail.ru/jump?from=2339008">
			
			<img src="//top-fwz1.mail.ru/counter?id=2339008;t=246;js=na" style="border:0;"
			
			height="31" width="88" alt="Рейтинг@Mail.ru" /></a></div></noscript>
			
			<!-- //Rating@Mail.ru counter -->
		</div>
    	<div>
			<!-- Top100 (Kraken) Widget -->
			<span id="top100_widget"></span>
			<!-- END Top100 (Kraken) Widget -->
			
			<!-- Top100 (Kraken) Counter -->
			<script>
				(function (w, d, c) {
				(w[c] = w[c] || []).push(function() {
					var options = {
						project: 6652090,
						element: 'top100_widget',
					};
					try {
						w.top100Counter = new top100(options);
					} catch(e) { }
				});
				var n = d.getElementsByTagName("script")[0],
				s = d.createElement("script"),
				f = function () { n.parentNode.insertBefore(s, n); };
				s.type = "text/javascript";
				s.async = true;
				s.src =
				(d.location.protocol == "https:" ? "https:" : "http:") +
				"//st.top100.ru/top100/top100.js";
			
				if (w.opera == "[object Opera]") {
				d.addEventListener("DOMContentLoaded", f, false);
			} else { f(); }
			})(window, document, "_top100q");
			</script>
			<noscript>
			<img src="//counter.rambler.ru/top100.cnt?pid=6652090" alt="Топ-100" />
			</noscript>
			<!-- END Top100 (Kraken) Counter -->
		</div>
		<div>
			<!-- HotLog -->
			<span id="hotlog_counter"></span>
			<span id="hotlog_dyn"></span>
			<script type="text/javascript">
			var hot_s = document.createElement('script');
			hot_s.type = 'text/javascript'; hot_s.async = true;
			hot_s.src = 'https://js.hotlog.ru/dcounter/2579812.js';
			hot_d = document.getElementById('hotlog_dyn');
			hot_d.appendChild(hot_s);
			</script>
			<noscript>
			<a href="https://click.hotlog.ru/?2579812" target="_blank"><img
			src="https://hit5.hotlog.ru/cgi-bin/hotlog/count?s=2579812&amp;im=353" border="0"
			alt="HotLog"></a>
			</noscript>
			<!-- /HotLog -->
		</div>
		<div>
			<!--LiveInternet counter--><script type="text/javascript">
			document.write("<a href='//www.liveinternet.ru/click' "+
			"target=_blank><img src='//counter.yadro.ru/hit?t53.11;r"+
			escape(document.referrer)+((typeof(screen)=="undefined")?"":
			";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
			screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
			";h"+escape(document.title.substring(0,150))+";"+Math.random()+
			"' alt='' title='LiveInternet: показано число просмотров и"+
			" посетителей за 24 часа' "+
			"border='0' width='88' height='31'><\/a>")
			</script><!--/LiveInternet-->
		</div>
	</div>
  </footer>	
			
	<script src="<?php echo '//'.MAIN_URL.'/jquery-3.5.1.min.js';?>"></script>
    <script src="<?php echo '//'.MAIN_URL.'/anime.min.js';?>"></script>
    <script src="<?php echo '//'.MAIN_URL.'/OwlCarousel/dist/owl.carousel.min.js';?>"></script>
	<script src="<?php echo '//'.MAIN_URL.'/script-nd.js';?>"></script>	
	<script src="<?php echo '//'.MAIN_URL.'/Trumbowyg-main/dist/trumbowyg.min.js';?>"></script>

	<?php 
		//Дополнительный код
		echo $scriptJScode = $scriptJScode ?? ''; ?>		

</body>
</html>	