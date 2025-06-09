export type FieldModifier<T> = {
    fieldName: keyof T;
    action: (value: any) => any;
};
