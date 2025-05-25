import { SortDirection } from '@admin/shared/enums/sortDirection';

export interface SortInterface {
  orderBy: string | null;
  direction: typeof SortDirection.ASC | typeof SortDirection.DESC;
}
