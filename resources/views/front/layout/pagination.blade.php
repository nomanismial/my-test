
@if ($paginator->hasPages())
    <div class="first_category container wrapper_con">
        <div class="row">
            <div class="col-md-12 mt-5 mb-2">
                <nav aria-label="Page navigation">
                    <ul class="pagination d-flex justify-content-center">
                        @if ($paginator->onFirstPage())
                        <li class="page-item"> <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous"> <span aria-hidden="true">«</span> <span class="sr-only">Previous</span> </a> </li>
                        @else
                        <li class="page-item"> <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous"> <span aria-hidden="true">«</span> <span class="sr-only">Previous</span> </a> </li>
                        @endif

                        @foreach ($elements as $element)
                            @if (is_string($element))
                                <li class="page-item disabled"><span>{{ $element }}</span></li>
                            @endif
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <li class="active page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @else
                                        <li class=" page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        @if ($paginator->hasMorePages())
                        <li class="page-item"> <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next"> <span aria-hidden="true">»</span> <span class="sr-only">Next</span> </a> </li>
                        @else
                        <li class="page-item"> <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next"> <span aria-hidden="true">»</span> <span class="sr-only">Next</span> </a> </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endif
