import React, { FC } from 'react';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';
import { Control, FieldErrors, Path, UseFormRegister } from 'react-hook-form';
import { AddressInvoice as AddressInvoiceInterface } from '@admin/common/interfaces/AddressInvoice';
import { SelectOption } from '@admin/common/types/selectOption';
import Street from '@admin/common/components/form/fields/Street';
import City from '@admin/common/components/form/fields/City';
import PostalCode from '@admin/common/components/form/fields/PostalCode';
import { createConditionalValidator } from '@admin/common/utils/formUtils';

interface AddressInvoiceProps<T extends AddressInvoiceInterface> {
    register: UseFormRegister<T>;
    control: Control<T>;
    fieldErrors: FieldErrors<T>;
    availableCountries: SelectOption[];
}


const AddressInvoiceFields = <T extends AddressInvoiceInterface>({
    register,
    control,
    fieldErrors,
    availableCountries,
}: AddressInvoiceProps<T>) => (
    <>
        <FormGroup label={<InputLabel isRequired={true} label="Ulica" htmlFor="invoiceStreet" />}>
            <Street register={register} fieldErrors={fieldErrors} fieldName="invoiceStreet" />
        </FormGroup>

        <FormGroup label={<InputLabel isRequired={true} label="Miasto" htmlFor="invoiceCity" />}>
            <City register={register} fieldErrors={fieldErrors} fieldName="invoiceCity" />
        </FormGroup>

        <FormGroup label={<InputLabel isRequired={true} label="Kod pocztowy" htmlFor="invoicePostalCode" />}>
            <PostalCode register={register} fieldErrors={fieldErrors} fieldName="invoicePostalCode" />
        </FormGroup>

        <FormGroup label={<InputLabel label="Nazwa firmy" htmlFor="invoiceCompanyName" />}>
            <InputField
                type="text"
                id="invoiceCompanyName"
                hasError={!!fieldErrors?.invoiceCompanyName}
                errorMessage={fieldErrors?.invoiceCompanyName?.message as string | undefined}
                icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register('invoiceCompanyName' as Path<T>, {
                    validate: createConditionalValidator(
                        validationRules.minLength(2),
                        validationRules.maxLength(255),
                    ),
                })}
            />
        </FormGroup>

        <FormGroup label={<InputLabel label="NIP" htmlFor="invoiceCompanyTaxId" />}>
            <InputField
                type="text"
                id="invoiceCompanyTaxId"
                hasError={!!fieldErrors?.invoiceCompanyTaxId}
                errorMessage={fieldErrors?.invoiceCompanyTaxId?.message as string | undefined}
                icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register('invoiceCompanyTaxId' as Path<T>, {
                    validate: createConditionalValidator(
                        validationRules.minLength(2),
                        validationRules.maxLength(255),
                    ),
                })}
            />
        </FormGroup>

        <FormGroup label={<InputLabel label="Kraj" isRequired={true} />}>
            <ControlledReactSelect
                name={"invoiceCountryId" as Path<T>}
                control={control}
                options={availableCountries}
                rules={{
                    ...validationRules.required(),
                }}
            />
        </FormGroup>
    </>
)

export default AddressInvoiceFields;
