<script type="text/javascript">
	$(document).ready(function () {

		url = '{{ url("admin/slider/slideshow/slideshowgalleries") }}';
		
		sliderImageMediaLibrary.init(function(checkedValues)
		{
			$.ajax({
				url         : url,
				type        : 'GET',
				data        : {'ids': checkedValues},
				success     : function(data)
				{
					if(data[0].type === 'photo')
						img = '<img alt="' + data[0].caption + '" src="' + data[0].path + '"/>';

					$('#slideshow_image').attr('src', data[0].path);
					$('input[name=image_id]').attr('value', data[0].id);
				}
			});
		});
	});
</script>
