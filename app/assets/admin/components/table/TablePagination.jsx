import ReactPaginate from 'react-paginate';
import PaginationFilter from '@/admin/components/table/Filters/PaginationFilter';

const TablePagination = ({ filters, setFilters, pagination }) => {
    const currentRendered = pagination.totalItems > 0 ? pagination.offset + 1 : 0;
    const currentShowingItems = pagination.limit * pagination.page;
    const showed = currentShowingItems > pagination.totalItems ? pagination.totalItems : currentShowingItems;

    const handlePaginationClick = ({ selected }) => {
        setFilters({
            ...filters,
            page: selected + 1,
        });
    };

    return (
        <div className="pt-5 px-2 flex justify-between border-t border-gray-100">
            <PaginationFilter filters={filters} setFilters={setFilters} />
            {pagination.totalPages > 1 && (
                <ReactPaginate
                    breakLabel="..."
                    nextLabel=" >"
                    previousLabel="< "
                    previousClassName="hover:bg-primary-light hover:text-primary h-[40px] w-[40px] rounded-full transition-all cursor-pointer"
                    previousLinkClassName="block w-full h-full text-center flex items-center justify-center"
                    nextClassName="hover:bg-primary-light hover:text-primary h-[40px] w-[40px] rounded-full transition-all cursor-pointer"
                    nextLinkClassName="block w-full h-full text-center flex items-center justify-center"
                    pageClassName="hover:bg-primary-light hover:text-primary h-[40px] w-[40px] rounded-full transition-all cursor-pointer"
                    pageLinkClassName="block w-full h-full text-center flex items-center justify-center"
                    activeClassName="bg-primary text-white h-[40px] w-[40px] rounded-full pointer-events-none font-medium"
                    activeLinkClassName="block w-full h-full text-center flex items-center justify-center"
                    pageCount={pagination.totalPages}
                    className="flex items-center gap-4 pagination-table"
                    onPageChange={handlePaginationClick}
                    forcePage={pagination.page - 1}
                    disabledClassName="pointer-events-none text-gray-300"
                />
            )}
            <p className="pt-3 text-sm font-medium text-center text-black border-t border-gray-100   xl:border-t-0 xl:pt-0 xl:text-left">
              {pagination.limit === -1 ? (
                <span>
                  Wyświetlane wszystkie {pagination.totalItems} wpisów.
                </span>
              ) : (
                <span>
                  Pokazywanie {currentRendered}–{showed} z {pagination.totalItems} wpisów.
                </span>
              )}
            </p>
        </div>
    );
};

export default TablePagination;
