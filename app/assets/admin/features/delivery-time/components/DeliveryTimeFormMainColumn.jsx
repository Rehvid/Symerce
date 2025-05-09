import { validationRules } from '@/admin/utils/validationRules';
import Input from '@/admin/components/form/controls/Input';
import Select from '@/admin/components/form/controls/Select';
import { Controller } from 'react-hook-form';
import NumberIcon from '@/images/icons/number.svg';
import LabelNameIcon from '@/images/icons/label-name.svg';

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
                icon={<LabelNameIcon className="text-gray-500 w-[24px] h-[24px]" />}
            />
            <Input
                {...register('minDays', {
                    ...validationRules.required(),
                    ...validationRules.min(0),
                })}
                type="number"
                id="minDays"
                label="Minimalne dni"
                hasError={!!fieldErrors?.minDays}
                errorMessage={fieldErrors?.minDays?.message}
                isRequired
                icon={<NumberIcon className="text-gray-500 w-[24px] h-[24px]" />}
            />
            <Input
                {...register('maxDays', {
                    ...validationRules.required(),
                    ...validationRules.min(1),
                })}
                type="number"
                id="maxDays"
                label="Maksymalne Dni"
                hasError={!!fieldErrors?.maxDays}
                errorMessage={fieldErrors?.maxDays?.message}
                isRequired
                icon={<NumberIcon className="text-gray-500 w-[24px] h-[24px]" />}
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
