<html>
	<head>
	  <?php echo javascript_include_tag('oasys_js/jquery-1.7.2.min') ?>
	  <script src="/js/oasys_js/jquery.PrintArea.js_4.js"></script>
      <script type="text/javascript">
        $(function() {
    		
    		$('.print').click(function() {
    			var container = $(this).attr('rel');
    			$('#' + container).printArea();
    			return false;
    		});
    		
    	});
      </script>
	</head>
	<body><?php echo $sf_data->getRaw('sf_content') ?></body>
</html>