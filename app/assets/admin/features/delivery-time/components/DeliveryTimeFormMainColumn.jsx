import { validationRules } from '@/admin/utils/validationRules';
import Input from '@/admin/components/form/controls/Input';
import Select from '@/admin/components/form/controls/Select';
import { Controller } from 'react-hook-form';

const DeliveryTimeFormMainColumn = ({ register, fieldErrors, formData, control }) => {
    return (
        <>
            <Input
                {...register('label', {
                    ...validationRules.required(),
                    ...validationRules.minLength(3),
                })}
                type="text"
                id="name"
                label="Nazwa"
                hasError={!!fieldErrors?.name}
                errorMessage={fieldErrors?.name?.message}
                isRequired
            />
            <Input
                {...register('minDays', {
                    ...validationRules.required(),
                    ...validationRules.min(0),
                })}
                type="text"
                id="minDays"
                label="Minimalne dni"
                hasError={!!fieldErrors?.minDays}
                errorMessage={fieldErrors?.minDays?.message}
                isRequired
            />
            <Input
                {...register('maxDays', {
                    ...validationRules.required(),
                    ...validationRules.min(1),
                })}
                type="text"
                id="maxDays"
                label="Maksymalne Dni"
                hasError={!!fieldErrors?.maxDays}
                errorMessage={fieldErrors?.maxDays?.message}
                isRequired
            />

           <Controller
            name="type"
            control={control}
            defaultValue={[]}
            render={({ field }) => (
              <div>
                <Select
                  label="Producent"
                  options={formData?.types || []}
                  selected={field.value}
                  onChange={(value) => {
                    field.onChange(value);
                  }}
                />
              </div>
            )}
          />
        </>
    );
};

export default DeliveryTimeFormMainColumn;
