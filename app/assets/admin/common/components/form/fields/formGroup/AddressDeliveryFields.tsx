import { AddressDelivery as AddressDeliveryInterface } from '@admin/common/interfaces/AddressDelivery';
import React from 'react';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import { validationRules } from '@admin/common/utils/validationRules';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';
import { Control, FieldErrors, Path, UseFormRegister } from 'react-hook-form';
import { SelectOption } from '@admin/common/types/selectOption';
import TextareaField from '@admin/common/components/form/input/TextareaField';
import Street from '@admin/common/components/form/fields/Street';
import PostalCode from '@admin/common/components/form/fields/PostalCode';
import City from '@admin/common/components/form/fields/City';

interface AddressDeliveryProps<T extends AddressDeliveryInterface> {
    register: UseFormRegister<T>;
    control: Control<T>;
    fieldErrors: FieldErrors<T>;
    availableCountries: SelectOption[];
    useDeliveryInstructions: boolean;
}

const AddressDeliveryFields = <T extends AddressDeliveryInterface>({
 register,
 control,
 fieldErrors,
 availableCountries,
 useDeliveryInstructions = false,
}: AddressDeliveryProps<T>) => (
    <>
        <FormGroup label={<InputLabel isRequired={true} label="Ulica" htmlFor="street" />}>
            <Street register={register} fieldErrors={fieldErrors} />
        </FormGroup>

        <FormGroup label={<InputLabel isRequired={true} label="Miasto" htmlFor="city" />}>
            <City register={register} fieldErrors={fieldErrors} />
        </FormGroup>

        <FormGroup label={<InputLabel isRequired={true} label="Kod pocztowy" htmlFor="postalCode" />}>
            <PostalCode register={register} fieldErrors={fieldErrors} />
        </FormGroup>

        <FormGroup label={<InputLabel label="Kraj" isRequired={true} />}>
            <ControlledReactSelect
                name={"countryId" as Path<T>}
                control={control}
                options={availableCountries}
                rules={{
                    ...validationRules.required(),
                }}
            />
        </FormGroup>

        {useDeliveryInstructions && (
            <FormGroup label={<InputLabel label="Instruckcje dostawy"  />}>
                <TextareaField {...register('deliveryInstructions' as Path<T>)} />
            </FormGroup>
        )}
    </>
)

export default AddressDeliveryFields;
