import FormSidePanel from '@/admin/components/form/FormSidePanel';
import Switch from '@/admin/components/form/controls/Switch';
import { validationRules } from '@/admin/utils/validationRules';
import MultiSelect from '@/admin/components/form/controls/MultiSelect';
import { Controller } from 'react-hook-form';
import Select from '@/admin/components/form/controls/Select';

const ProductFormSideColumn = ({ register, control, fieldErrors, formData }) => {
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

                <Controller
                    name="vendor"
                    control={control}
                    defaultValue={[]}
                    render={({ field }) => (
                        <div>
                            <Select
                                label="Producent"
                                options={formData?.optionVendors || []}
                                selected={field.value}
                                onChange={(value) => {
                                    field.onChange(value);
                                }}
                            />
                        </div>
                    )}
                />

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
                    {Object.entries(formData.optionAttributes).map(([key, optionValue]) => (
                        <Controller
                            key={key}
                            name={`attributes[${optionValue['name']}]`}
                            control={control}
                            defaultValue={[]}
                            render={({ field }) => (
                                <div>
                                    <MultiSelect
                                        label={optionValue['label']}
                                        options={optionValue['options'] || []}
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
    );
};

export default ProductFormSideColumn;
