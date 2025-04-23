import FormSidePanel from '@/admin/components/form/FormSidePanel';
import Switch from '@/admin/components/form/controls/Switch';
import { validationRules } from '@/admin/utils/validationRules';
import MultiSelect from '@/admin/components/form/controls/MultiSelect';
import { Controller } from 'react-hook-form';
import Select from '@/shared/components/Select';

const ProductFormSideColumn = ({register, control, fieldErrors, formData, setValue}) => {
  const attributes = Object.values(formData?.optionAttributes || {});

  return (
    <div className="flex flex-col h-full gap-[2.5rem]">
      <FormSidePanel sectionTitle="Informacje">
        <Switch label="Aktywny?" {...register('isActive')} />

        <Controller
          name="categories"
          control={control}
          defaultValue={[]}
          rules={{
            ...validationRules.required(),
          }}
          render={({ field }) => (
            <div>
              <MultiSelect
                label="Kategorie"
                options={formData?.optionCategories || []}
                selected={field.value}
                onChange={(value, checked) => {
                  const newValue = checked
                    ? [...field.value, value]
                    : field.value.filter((v) => v !== value);
                  field.onChange(newValue);
                }}
                isRequired
                hasError={!!fieldErrors?.categories}
                errorMessage={fieldErrors?.categories?.message}
              />
            </div>
          )}
        />

        <Controller
          name="tags"
          control={control}
          defaultValue={[]}
          render={({ field }) => (
            <div>
              <MultiSelect
                label="Tagi"
                options={formData?.optionTags || []}
                selected={field.value}
                onChange={(value, checked) => {
                  const newValue = checked
                    ? [...field.value, value]
                    : field.value.filter((v) => v !== value);
                  field.onChange(newValue);
                }}
              />
            </div>
          )}
        />

        {formData.optionVendors && (
          <Select
            label="Producent"
            id="Vendor"
            options={formData?.optionVendors || []}
            selected={formData?.vendor || ''}
            onChange={(e) => {
              setValue('vendor', e.target.value)
            }}
          />
        )}

        <Controller
          name="deliveryTimes"
          control={control}
          defaultValue={[]}
          rules={{
            ...validationRules.required(),
          }}
          render={({ field }) => (
            <div>
              <MultiSelect
                label="Czasy dostawy"
                options={formData?.optionDeliveryTimes || []}
                selected={field.value}
                onChange={(value, checked) => {
                  const newValue = checked
                    ? [...field.value, value]
                    : field.value.filter((v) => v !== value);
                  field.onChange(newValue);
                }}
                isRequired
                hasError={!!fieldErrors?.deliveryTimes}
                errorMessage={fieldErrors?.deliveryTimes?.message}
              />
            </div>
          )}
        />

      </FormSidePanel>
      {attributes.length > 0 && (
        <FormSidePanel sectionTitle="Atrybuty">
          {Object.entries(formData.optionAttributes).map(([key, value]) => (
            <Controller
              key={key}
              name={`attributes[${value['name']}]`}
              control={control}
              defaultValue={[]}
              render={({ field }) => (
                <div>
                  <MultiSelect
                    label={value['label']}
                    options={value['options'] || []}
                    selected={field.value}
                    onChange={(value, checked) => {
                      const newValue = checked
                        ? [...field.value, value]
                        : field.value.filter((v) => v !== value);
                      field.onChange(newValue);
                    }}
                  />
                </div>
              )}
            />
          ))}
        </FormSidePanel>
      )}

    </div>
  )
}

export default ProductFormSideColumn;
