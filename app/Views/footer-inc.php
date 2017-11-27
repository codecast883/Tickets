</div>
<script src="https://vk.com/js/api/xd_connection.js?2"  type="text/javascript"></script>


<script src="/js/vendor/modernizr-3.5.0.min.js"></script>



<script src="/js/vendor/jquery.json.min.js"></script>
<script src="/js/vendor/jquery.maskedinput.min.js"></script>
<script src="/js/plugins.js"></script>
<script>

        var minPeople = +'<?=$this->eventData->min_people;?>';
        var maxPeople = +'<?=$this->eventData->max_people;?>';
        var isDeploy = <?=DEPLOYMENT?>;
        var calculationPriceType = +'<?=$this->eventData->calculation_price_type;?>';
        var dataPeoplesObject = $.parseJSON('<?=$priceCountPeoplesJson?>');


</script>
<script src="/js/main.js"></script>

<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<script>
    window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
    ga('create','UA-XXXXX-Y','auto');ga('send','pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async defer></script>




</body>
</html>