<?php
$warnings = collect([]);
if (auth()->check()) {
    $warnings = \Packages\Warnings\App\Models\Warning::where('user_id', auth()->user()->id)->get();
}
?>

@if ($warnings->count())
<section class="hero-area bg-white shadow-sm overflow-hidden pt-60px">
    <span class="stroke-shape stroke-shape-1"></span>
    <span class="stroke-shape stroke-shape-2"></span>
    <span class="stroke-shape stroke-shape-3"></span>
    <span class="stroke-shape stroke-shape-4"></span>
    <span class="stroke-shape stroke-shape-5"></span>
    <span class="stroke-shape stroke-shape-6"></span>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="hero-content">
                    @foreach($warnings as $warning)
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">Warning!</h4>
                        <p>{{ $warning->body }}</p>
                        <hr>
                        <p class="mb-0"><a href="{{ route('warnings.destroy', $warning->id) }}"><i class="la la-trash"></i></a></p>
                    </div>
                    @endforeach
                </div><!-- end hero-content -->
            </div><!-- end col-lg-8 -->
        </div><!-- end row -->
    </div><!-- end container -->
</section>
@endif

