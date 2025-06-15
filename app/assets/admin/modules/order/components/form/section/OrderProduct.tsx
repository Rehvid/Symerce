import React from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import { DynamicFields } from '@admin/common/components/form/DynamicFields';
import InputField from '@admin/common/components/form/input/InputField';
import { Control, FieldErrors, Path, UseFormRegister } from 'react-hook-form';
import { validationRules } from '@admin/common/utils/validationRules';
import { OrderFormData } from '@admin/modules/order/interfaces/OrderFormData';
import { OrderFormContext } from '@admin/modules/order/interfaces/OrderFormContext';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import FormGroup from '@/admin/common/components/form/FormGroup';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';

interface OrderProductProps {
    register: UseFormRegister<OrderFormData>;
    control: Control<OrderFormData>;
    fieldErrors: FieldErrors<OrderFormData>;
    formContext: OrderFormContext;
}

const OrderProduct: React.FC<OrderProductProps> = ({ register, control, fieldErrors, formContext }) => {
    return (
        <FormSection title="Produkty w zamówieniu">
            <DynamicFields
                name="products"
                control={control}
                renderItem={(index, namePrefix) => (
                    <div className="space-y-2 flex flex-col gap-4">
                        <FormGroup label={<InputLabel isRequired={true} label="Produkt" />}>
                            <ControlledReactSelect
                                name={`${namePrefix}.productId` as Path<OrderFormData>}
                                control={control}
                                options={formContext?.availableProducts || []}
                                rules={{
                                    ...validationRules.required(),
                                }}
                            />
                        </FormGroup>
                        <FormGroup label={<InputLabel isRequired={true} label="Ilość" />}>
                            <InputField
                                {...register(`${namePrefix}.quantity` as Path<OrderFormData>, {
                                    ...validationRules.required(),
                                    ...validationRules.min(1),
                                })}
                                placeholder="Ilość"
                                type="number"
                                hasError={!!fieldErrors?.products?.[index]?.quantity}
                                errorMessage={fieldErrors?.products?.[index]?.quantity?.message}
                            />
                        </FormGroup>
                    </div>
                )}
            />
        </FormSection>
    );
};

export default OrderProduct;
