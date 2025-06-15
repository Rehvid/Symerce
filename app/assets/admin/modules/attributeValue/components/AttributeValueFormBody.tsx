import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import React, { FC } from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import { AttributeValueFormData } from '@admin/modules/attributeValue/interfaces/AttributeValueFormData';
import { FieldErrors, UseFormRegister } from 'react-hook-form';
import GenericTextField from '@admin/common/components/form/fields/formGroup/GenericTextField';

interface AttributeValueFormBodyProps {
    register: UseFormRegister<AttributeValueFormData>;
    fieldErrors: FieldErrors<AttributeValueFormData>;
}

const AttributeValueFormBody: FC<AttributeValueFormBodyProps> = ({ register, fieldErrors }) => (
    <FormSection title="Informacje" useToggleContent={false}>
        <GenericTextField register={register} fieldErrors={fieldErrors} fieldName={"value"} label={"Wartość"} />
    </FormSection>
);

export default AttributeValueFormBody;
