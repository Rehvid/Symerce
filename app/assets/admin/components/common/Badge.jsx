const Badge = ({children}) => {
  return (
    <span className="inline-flex items-center px-2 py-1  text-xs font-medium text-blue-800 bg-blue-100 rounded-lg">
      {children}
    </span>
  )
}

export default Badge;
