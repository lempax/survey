@extends('layouts.master')

@section('additional_styles')
<link rel="stylesheet" href="{{ asset ("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.css") }}">
<link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css") }} ">
@endsection

@section('content')
<?php $container = 0;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        {{ $survey->title }}
    </div>
    <div class="box-body">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th data-field="id">Question</th>
                    <th data-field="name">Answer(s)</th>
                </tr>
            </thead>
            @forelse ($survey->questions as $item)
            <tr>
                @if($item->question_type === 'radio' || $item->question_type === 'checkbox')
                <td class="col-md-6">{{ $item->title }}</td>
                <td>
                    <?php
                    $array = $item->answers;
                    $counter = array();
                    ?>

                    <?php
                    for ($x = 0; $x < count($item->answers); $x++) {

                        if (!array_key_exists($array[$x]['answer'], $counter)) {
                            $counter[] = $array[$x]['answer'];
                        } else {
                            $counter[$x]['answer'] ++;
                        }

                        if ($x == count($item->answers) - 1) {
                            foreach (array_count_values($counter) AS $key => $value) {
                                echo '<small class="label label-success" style="float: left; margin-right: 10px; margin-top: 3px;">' . $value . '</small><span class="text-bold" style="float: left;">' . $key . '</span> <br>';
                            }
                        }
                    }
                    ?>
                    @else
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td>
                    No answers provided by you for this Survey
                </td>
                <td></td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection