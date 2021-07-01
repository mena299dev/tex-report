<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<!-- Form สนค -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Form</a>
    <ul class="nav-dropdown-items">
        @role('Super Admin')
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>ประมาณการรายรับประจำปีงบประมาณ</span></a></li>
        @endrole
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>สนค.01</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{url('fd-02-1')}}"><i class="nav-icon la la-id-badge"></i> <span>สนค.02-1</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{url('fd-02-2')}}"><i class="nav-icon la la-id-badge"></i> <span>สนค.02-2</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{url('fd-02-3')}}"><i class="nav-icon la la-id-badge"></i> <span>สนค.02-3</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{url('fd-02-4')}}"><i class="nav-icon la la-id-badge"></i> <span>สนค.02-4</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{url('form-count')}}"><i class="nav-icon la la-id-badge"></i> <span>จำนวนแบบยื่น/จำนวนราย</span></a></li>
    </ul>
</li>

<!-- Report สนค -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Report</a>
    <ul class="nav-dropdown-items">
        @role('Super Admin')
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>ประมาณการรายรับประจำปีงบประมาณ</span></a></li>
        @endrole
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>สนค.01</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{url('report/fd-02-1')}}"><i class="nav-icon la la-id-badge"></i> <span>สนค.02-1</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{url('report/fd-02-2')}}"><i class="nav-icon la la-id-badge"></i> <span>สนค.02-2</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{url('report/fd-02-3')}}"><i class="nav-icon la la-id-badge"></i> <span>สนค.02-3</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-id-badge"></i> <span>สนค.02-4</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-id-badge"></i> <span>จำนวนแบบยื่น/จำนวนราย</span></a></li>
    </ul>
</li>

@role('Super Admin')
<!-- Users, Roles, Permissions -->
<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-users"></i> Authentication</a>
    <ul class="nav-dropdown-items">
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="nav-icon la la-user"></i> <span>Users</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('role') }}"><i class="nav-icon la la-id-badge"></i> <span>Roles</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ backpack_url('permission') }}"><i class="nav-icon la la-key"></i> <span>Permissions</span></a></li>
    </ul>
</li>
@endrole
