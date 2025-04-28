import SelectFilter from '@/admin/components/table/Filters/SelectFilter';

const ActiveFilter = ({filters, setFilters}) => (
  <SelectFilter
    filters={filters}
    setFilters={setFilters}
    nameFilter="isActive"
    options={[
      {label: 'Aktywny', value: true},
      {label: 'Nieaktywny', value: false}
    ]}
  />
)

export default ActiveFilter;
