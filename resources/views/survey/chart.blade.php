@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") }} ">
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-body">
        <div class="box-body col-md-4">
            <div id="calls" style="height: 400px;"></div>
        </div>
        <div class="box-body col-md-4">
            <div id="prod" style="height: 400px;"></div>
        </div>
        <div class="box-body col-md-4">
            <div id="third" style="height: 400px;"></div>
        </div>
        <div class="box-body col-md-4">
            <div id="fourth" style="height: 400px;"></div>
        </div>
        <div class="box-body col-md-4">
            <div id="fifth" style="height: 400px;"></div>
        </div>
        <div class="box-body col-md-4">
            <div id="six" style="height: 400px;"></div>
        </div>
        <div class="box-body col-md-4">
            <div id="seven" style="height: 400px;"></div>
        </div>
        <div class="box-body col-md-4">
            <div id="eight" style="height: 400px;"></div>
        </div>
    </div>
</div>
@endsection

@section('additional_scripts')
<script type="text/javascript" src="{{ asset ("/canvasjs/canvasjs.min.js") }}"></script>

<script type="text/javascript">
window.onload = function () {
	var chart = new CanvasJS.Chart("calls", {
		theme: "theme",//theme1
		title:{
			text: "Question 1"              
		},
		animationEnabled: false,   // change to true
		data: [              
		{
			type: "column",
			dataPoints: [
				{ label: "Strongly Agree",  y: 2  },
				{ label: "Agree", y: 1  },
				{ label: "Neutral", y: 1  },
				{ label: "Disagree",  y: 1  },
				{ label: "Strongly Disagree",  y: 1  }
			]
		}
		]
	});
	chart.render();
        
        var prod = new CanvasJS.Chart("prod", {
		theme: "theme",//theme1
		title:{
			text: "Question 2"              
		},
		animationEnabled: false,   // change to true
		data: [              
		{
			type: "column",
			dataPoints: [
				{ label: "Strongly Agree",  y: 1  },
				{ label: "Agree", y: 2  },
				{ label: "Neutral", y: 1  },
				{ label: "Disagree",  y: 2  },
				{ label: "Strongly Disagree",  y: 0  }
			]
		}
		]
	});
	prod.render();
        
        var third = new CanvasJS.Chart("third", {
		theme: "theme",//theme1
		title:{
			text: "Question 3"              
		},
		animationEnabled: false,   // change to true
		data: [              
		{
			type: "column",
			dataPoints: [
				{ label: "Strongly Agree",  y: 0  },
				{ label: "Agree", y: 1  },
				{ label: "Neutral", y: 5  },
				{ label: "Disagree",  y: 0  },
				{ label: "Strongly Disagree",  y: 0  }
			]
		}
		]
	});
	third.render();
        
        var fourth = new CanvasJS.Chart("fourth", {
		theme: "theme",//theme1
		title:{
			text: "Question 4"              
		},
		animationEnabled: false,   // change to true
		data: [              
		{
			type: "column",
			dataPoints: [
				{ label: "Strongly Agree",  y: 0  },
				{ label: "Agree", y: 2  },
				{ label: "Neutral", y: 2  },
				{ label: "Disagree",  y: 2  },
				{ label: "Strongly Disagree",  y: 0  }
			]
		}
		]
	});
	fourth.render();
        
        var fifth = new CanvasJS.Chart("fifth", {
		theme: "theme",//theme1
		title:{
			text: "Question 5"              
		},
		animationEnabled: false,   // change to true
		data: [              
		{
			type: "column",
			dataPoints: [
				{ label: "Strongly Agree",  y: 0  },
				{ label: "Agree", y: 0  },
				{ label: "Neutral", y: 1  },
				{ label: "Disagree",  y: 1  },
				{ label: "Strongly Disagree",  y: 4  }
			]
		}
		]
	});
	fifth.render();
        
        var six = new CanvasJS.Chart("six", {
		theme: "theme",//theme1
		title:{
			text: "Question 6"              
		},
		animationEnabled: false,   // change to true
		data: [              
		{
			type: "column",
			dataPoints: [
				{ label: "Strongly Agree",  y: 0  },
				{ label: "Agree", y: 2  },
				{ label: "Neutral", y: 0  },
				{ label: "Disagree",  y: 2  },
				{ label: "Strongly Disagree",  y: 2  }
			]
		}
		]
	});
	six.render();
}
</script>
@endsection