import { AddressDelivery as AddressDeliveryInterface } from '@admin/common/interfaces/AddressDelivery';
import React, { FC } from 'react';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';
import { Control, FieldErrors, Path, UseFormRegister } from 'react-hook-form';
import { SelectOption } from '@admin/common/types/selectOption';
import TextareaField from '@admin/common/components/form/input/TextareaField';

interface AddressDeliveryProps<T extends AddressDeliveryInterface> {
    register: UseFormRegister<T>;
    control: Control<T>;
    fieldErrors: FieldErrors<T>;
    availableCountries: SelectOption[];
    useDeliveryInstructions: boolean;
}

const AddressDelivery = <T extends AddressDeliveryInterface>({
 register,
 control,
 fieldErrors,
 availableCountries,
 useDeliveryInstructions = false,
}: AddressDeliveryProps<T>) => (
    <>
        <FormGroup label={<InputLabel isRequired={true} label="Ulica" htmlFor="street" />}>
            <InputField
                type="text"
                id="street"
                hasError={!!fieldErrors?.street}
                errorMessage={fieldErrors?.street?.message as string | undefined}
                icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register('street' as Path<T>, {
                    ...validationRules.required(),
                    ...validationRules.minLength(2),
                })}
            />
        </FormGroup>

        <FormGroup label={<InputLabel isRequired={true} label="Miasto" htmlFor="city" />}>
            <InputField
                type="text"
                id="city"
                hasError={!!fieldErrors?.city}
                errorMessage={fieldErrors?.city?.message as string | undefined}
                icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register('city' as Path<T>, {
                    ...validationRules.required(),
                    ...validationRules.minLength(2),
                })}
            />
        </FormGroup>

        <FormGroup label={<InputLabel isRequired={true} label="Kod pocztowy" htmlFor="postalCode" />}>
            <InputField
                type="text"
                id="postalCode"
                hasError={!!fieldErrors?.postalCode}
                errorMessage={fieldErrors?.postalCode?.message as string | undefined}
                icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register('postalCode' as Path<T>, {
                    ...validationRules.required(),
                    ...validationRules.minLength(4),
                })}
            />
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

export default AddressDelivery;
