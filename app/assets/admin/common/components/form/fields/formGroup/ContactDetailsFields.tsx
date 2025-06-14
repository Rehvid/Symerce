import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import Firstname from '@admin/common/components/form/fields/Firstname';
import Surname from '@admin/common/components/form/fields/Surname';
import Email from '@admin/common/components/form/fields/Email';
import Phone from '@admin/common/components/form/fields/Phone';
import React from 'react';
import { FieldErrors, FieldValues, UseFormRegister } from 'react-hook-form';

interface ContactDetailsFieldsProps<T extends FieldValues> {
    register: UseFormRegister<T>;
    fieldErrors: FieldErrors<T>;
}

const ContactDetailsFields = <T extends FieldValues>({
    register,
    fieldErrors,
}: ContactDetailsFieldsProps<T>) => (
    <>
        <FormGroup label={<InputLabel isRequired={true} label="Imie" htmlFor="firstname" />}>
            <Firstname fieldErrors={fieldErrors} register={register} />
        </FormGroup>
        <FormGroup label={<InputLabel isRequired={true} label="Nazwisko" htmlFor="surname" />}>
            <Surname register={register} fieldErrors={fieldErrors}  />
        </FormGroup>

        <FormGroup label={<InputLabel isRequired={true} label="Email" htmlFor="email" />}>
            <Email register={register} fieldErrors={fieldErrors} isRequired={true} />
        </FormGroup>

        <FormGroup label={<InputLabel  label="Telefon" htmlFor="phone" />}>
            <Phone register={register} fieldErrors={fieldErrors} isRequired={false} />
        </FormGroup>
    </>
)

export default ContactDetailsFields;
