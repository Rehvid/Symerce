import { SortDirection } from '@admin/common/enums/sortDirection';

export interface SortInterface {
  orderBy: string | null;
  direction: typeof SortDirection.ASC | typeof SortDirection.DESC;
}
