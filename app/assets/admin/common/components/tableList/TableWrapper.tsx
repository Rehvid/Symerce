import React, { FC } from 'react';
import SuspenseFallback from '@admin/pages/SuspenseFallback';

interface TableWrapperProps {
    children: React.ReactNode;
    isLoading: boolean,
}
const TableWrapper: FC<TableWrapperProps> = ({children, isLoading}) => (
    <div className={`relative rounded-xl bg-white shadow mb-5 mt-[1.5rem] overflow-x-auto ${isLoading ? 'pointer-events-none' : ''}`}>
        <table className="table space-y-6 w-full rounded-xl border-separate border-spacing-0">
            {children}
        </table>

        {isLoading && (
            <div className="absolute inset-0 bg-black/85 flex rounded-xl  pt-6 w-full">
                <div className="flex items-center justify-center w-full">
                    <SuspenseFallback />
                </div>
            </div>
        )}
    </div>
)

export default TableWrapper;
