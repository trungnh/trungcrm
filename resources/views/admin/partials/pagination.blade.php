@verbatim
    <!-- Pagination -->
    <div class="card-footer py-4" v-if="pagination.total > pagination.per_page">
        <nav aria-label="...">
            <ul class="pagination justify-content-end mb-0">
                <li class="page-item disabled" v-if="pagination.current_page > 1">
                    <a class="page-link" href="#" tabindex="-1" @click.prevent="changePage(pagination.current_page - 1)">
                        <i class="fas fa-angle-left"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <li v-for="page in pagesNumber" v-bind:class="[page == isActived ? 'page-item active' : 'page-item']">
                    <a href="#" class="page-link" @click.prevent="changePage(page)">{{ page }}</a>
                </li>
                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                    <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page + 1)">
                        <i class="fas fa-angle-right"></i>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- End Pagination -->
@endverbatim
