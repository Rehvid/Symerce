import React from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import { Control, FieldErrors, UseFormRegister } from 'react-hook-form';
import { validationRules } from '@admin/common/utils/validationRules';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputField from '@admin/common/components/form/input/InputField';
import Description from '@admin/common/components/Description';
import { OrderFormData } from '@admin/modules/order/interfaces/OrderFormData';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';
import { OrderFormContext } from '@admin/modules/order/interfaces/OrderFormContext';
import FormSwitchField from '@admin/common/components/form/fields/formGroup/FormSwitchField';

interface OrderInformationProps {
    register: UseFormRegister<OrderFormData>;
    control: Control<OrderFormData>;
    fieldErrors: FieldErrors<OrderFormData>;
    isEditMode: boolean;
    formData?: OrderFormData;
    formContext?: OrderFormContext;
    useCustomer?: boolean;
}

const OrderInformation: React.FC<OrderInformationProps> = ({ register, control, isEditMode, formContext, formData, useCustomer, fieldErrors }) => {
    return (
        <FormSection title="Podstawowe informacje">
            <FormGroup label={<InputLabel isRequired={true} label="Status" htmlFor="status" />}>
                <ControlledReactSelect
                    name="status"
                    control={control}
                    rules={{
                        ...validationRules.required(),
                    }}
                    options={formContext?.availableStatuses || []}
                />
            </FormGroup>
            <FormGroup label={<InputLabel isRequired={true} label="Krok w zamówieniu" htmlFor="checkoutStep" />}>
                <ControlledReactSelect
                    name="checkoutStep"
                    control={control}
                    rules={{
                        ...validationRules.required(),
                    }}
                    options={formContext?.availableCheckoutSteps || []}
                />
            </FormGroup>
            {isEditMode && (
                <FormGroup
                    label={<InputLabel label="UUID" htmlFor="uuid" />}
                    description={<Description>Automatycznie generowana wartość, nie ma możliwości edycji.</Description>}
                >
                    <InputField type="text" id="uuid" disabled readOnly defaultValue={formData?.uuid} />
                </FormGroup>
            )}

            <FormSwitchField register={register}  fieldErrors={fieldErrors} name="useCustomer" label="Dodać klienta z bazy" />

            {useCustomer && (
                <FormGroup label={<InputLabel isRequired={true} label="Klient" htmlFor="customerId" />}>
                    <ControlledReactSelect
                        name="customerId"
                        control={control}
                        options={formContext?.availableCustomers}
                        rules={{
                            ...validationRules.required(),
                        }}
                    />
                </FormGroup>
            )}
        </FormSection>
    );
};

export default OrderInformation;
