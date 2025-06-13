import { SortDirection } from '@admin/common/enums/sortDirection';

export interface Sort {
    orderBy: string | null;
    direction: typeof SortDirection.ASC | typeof SortDirection.DESC | null;
}
