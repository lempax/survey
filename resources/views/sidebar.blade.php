<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ url('/profile_img/' . Auth::user()->uid) }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-pie-chart"></i> <span>Performance Management</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('productivity') }}"><i class="fa fa-circle-o"></i> Productivity</a></li>
                    <li><a href="{{ url('feedbacks') }}"><i class="fa fa-circle-o"></i> CRR Ratings</a></li>
                    <li><a href="{{ url('blacklist') }}"><i class="fa fa-circle-o"></i> Blacklist Rating</a></li>
                    <li><a href="{{ url('sasupsells') }}"><i class="fa fa-circle-o"></i> SAS Upsells</a></li>
                    <li><a href="{{ url('cosmocom') }}"><i class="fa fa-circle-o"></i> Cosmocom</a></li>
                </ul>
            </li>

            @if(in_array(Auth::user()->uid, array(21225273, 21464812)))
            <?php $date = \Carbon\Carbon::now(); ?>

            <li class="treeview">
                <a href="#"><i class="fa fa-archive"></i> <span>AFIS</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('iteminventory/view') }}"><i class="fa fa-circle-o"></i> Inventory</a></li>
                    <li><a href="{{ url('items/newform') }}"><i class="fa fa-circle-o"></i> Issuance</a></li>
                    <li><a href="{{ url('returneditem/create') }}"><i class="fa fa-circle-o"></i> Returned Items</a></li>
                    <li><a href="{{ url('createmenu/'.$date->format("W").'') }}"><i class="fa fa-circle-o"></i> Create Menu</a></li>
                </ul>
            </li>
            
            @endif
            
            <li class="treeview">
                <a href="#"><i class="fa fa-users"></i> <span>Tools</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('cases/loadform') }}"><i class="fa fa-circle-o"></i> Case Logger</a></li>
                    <li><a href="{{ url('nofeedback/create') }}"><i class="fa fa-circle-o"></i> No Feedback</a></li>
                    <li><a href="{{ url('sas/newcase') }}"><i class="fa fa-circle-o"></i> SAS Low Performers</a></li>
                    <li><a href="{{ url('supervisorycalls/new') }}"><i class="fa fa-circle-o"></i> Supervisory Calls</a></li>
                    <li><a href="{{ url('mailtophone/newmailtophone') }}"><i class="fa fa-circle-o"></i> Mail to Phone</a></li>
                    <li><a href="{{ url('cafeteria') }}"><i class="fa fa-circle-o"></i> Cafeteria Menu</a></li>
                    <li><a href="{{ url('uslogger') }}"><i class="fa fa-circle-o"></i> Log SAS Cases</a></li>
                </ul>
            </li>
            
            <li class="treeview">
                <a href="#"><i class="fa fa-user"></i> <span>Sup/2nd</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('coachingform') }}"><i class="fa fa-circle-o"></i> Coaching Form</a></li>
                    @if(in_array(Auth::user()->uid, array(21238078, 21403666)))
                        <li><a href="{{ url('irforms') }}"><i class="fa fa-circle-o"></i> Incident Report</a></li>
                    @endif
                    <li><a href="{{ url('masterreport') }}"><i class="fa fa-circle-o"></i> 3 Hour Report</a></li>
                    <li><a href="{{ url('slpc/newcase') }}"><i class="fa fa-circle-o"></i> Pending Concern</a></li>
                    <li><a href="{{ url('debriefing/create') }}"><i class="fa fa-circle-o"></i> Debriefing</a></li>
                    <li><a href="{{ url('bugrequest/create') }}"><i class="fa fa-circle-o"></i> Bug Request</a></li>
                    <li><a href="{{ url('uslogger') }}"><i class="fa fa-circle-o"></i> US SAS Logger</a></li>
                </ul>
            </li>
            
            @if(in_array(Auth::user()->departmentid, array(21386574, 21440024)))
            <li class="treeview">
                <a href="#"><i class="fa fa-folder-open"></i> <span>Mail.com</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('freemailers/create') }}"><i class="fa fa-circle-o"></i> FreeMailers</a></li>
                    <li><a href="{{ url('mcc/newcase') }}"><i class="fa fa-circle-o"></i> Cancelled Cases</a></li>
                    <li><a href="{{ url('msas/newcase') }}"><i class="fa fa-circle-o"></i> SAS</a></li>
                    <li><a href="{{ url('mct/newcase') }}"><i class="fa fa-circle-o"></i> Mindersaldo Cases</a></li>
                    <li><a href="{{ url('retentioncase/create') }}"><i class="fa fa-circle-o"></i> Retention </a></li>
                    <li><a href="{{ url('cancellationrequests/create') }}"><i class="fa fa-circle-o"></i> Cancellation Request</a></li>
                    <li><a href="{{ url('feedback/create') }}"><i class="fa fa-circle-o"></i> Feedback</a></li>
                </ul>
            </li>
            
            @else

            <li class="treeview">
                <a href="#"><i class="fa fa-bar-chart"></i><span>SAS Availability</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('sas/dashboard') }}"><i class="fa fa-circle-o"></i> SAS Dashboard</a></li>
                    <li><a href="{{ url('sas/payouts') }}"><i class="fa fa-circle-o"></i> SAS Payouts</a></li>
                    <li><a href="{{ url('sas/payout_breakdown') }}"><i class="fa fa-circle-o"></i> SAS Payout Breakdown</a></li>
                    <li><a href="{{ url('sas/gofo') }}"><i class="fa fa-circle-o"></i> FO VS. GO</a></li>
                    <li><a href="{{ url('sas') }}"><i class="fa fa-circle-o"></i> FO, GO, TC Breakdown</a></li>
                    <li><a href="{{ url('sas') }}"><i class="fa fa-circle-o"></i> SAS Steering</a></li>
                    <li><a href="{{ url('sas/runningsas') }}"><i class="fa fa-circle-o"></i> SAS Week on Week</a></li>
                    <li><a href="{{ url('sas/featured') }}"><i class="fa fa-circle-o"></i> Featured Products</a></li>
                    <li><a href="{{ url('sas/gross') }}"><i class="fa fa-circle-o"></i> Gross Products</a></li>
                    <li><a href="{{ url('sas/tariff') }}"><i class="fa fa-circle-o"></i> Tariff Change</a></li>
                    <li><a href="{{ url('sas/reports') }}"><i class="fa fa-circle-o"></i> Generate SAS Reports</a></li>
                </ul>
            </li>
            
            <li class="active"><a href="{{ url('agentstat') }}"><i class="fa fa-line-chart"></i> <span>Agent Stats</span></a></li>
            
            @endif
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>