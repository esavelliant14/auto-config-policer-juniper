import sys
from jnpr.junos import Device
from lxml import etree
import mysql.connector

device_ip = sys.argv[1]
iface_name = sys.argv[2]
unit_filter = sys.argv[3]

dev = Device(host=device_ip, user='juniper', passwd='juniper123')
dev.open()

# filter interface sesuai input
filter_xml = etree.XML(f'''
<configuration>
  <interfaces>
    <interface>
      <name>{iface_name}</name>
    </interface>
  </interfaces>
</configuration>
''')

cfg = dev.rpc.get_config(filter_xml=filter_xml)

interface_name = cfg.findtext('.//interface/name')

output_lines = []  # untuk tampung hasil

for unit in cfg.xpath('.//unit'):
    unit_name = unit.findtext('name')
    # kalau user masukkan unit tertentu, filter di sini
    if unit_filter and unit_filter != unit_name:
        continue

    attr_unit = unit.get('inactive')
    if attr_unit:
        status_unit_1 = "Inactive"
    else:
        status_unit_1 = "Active"

    #check disable atau tidak
    if unit.find('disable') is not None:
        status_unit_2 = "Disable"
    else:
        status_unit_2 = "Enable"
    status_unit = f"{status_unit_1} | {status_unit_2}"
    
    #description
    description = unit.findtext('description')
    
    #vlan-id
    vlan_id = unit.findtext('vlan-id')

    # ambil semua IP address + status inactive
    ip_list = []
    for addr_el in unit.xpath('family/inet/address'):
        ip_addr = addr_el.findtext('name')
        inactive_attr = addr_el.get('inactive')
        if inactive_attr:  # ada attribute inactive
            ip_list.append(f"{ip_addr}(inactive)")
        else:
            ip_list.append(ip_addr)
    ip = ", ".join(ip_list) if ip_list else "None"

    #status policer
    find_status_policer = unit.find('.//family/inet/policer')
    if find_status_policer is None:
        status_policer = "None"
    else:
        attr_policer = find_status_policer.get('inactive')
        if attr_policer:
            status_policer = "Inactive"
        else:
            status_policer = "Active"

    #status policer input
    find_status_input_policer = unit.find('.//family/inet/policer/input')
    if find_status_input_policer is None:
        status_input_policer = "None"
    else:
        attr_input_policer = find_status_input_policer.get('inactive')
        if attr_input_policer:
            status_input_policer = "Inactive"
        else:
            status_input_policer = "Active"
            
    #status policer output
    find_status_output_policer = unit.find('.//family/inet/policer/output')
    if find_status_output_policer is None:
        status_output_policer = "None"
    else:
        attr_output_policer = find_status_output_policer.get('inactive')
        if attr_output_policer:
            status_output_policer = "Inactive"
        else:
            status_output_policer = "Active"
            
    #value policer input & output
    raw_input_policer = unit.findtext('family/inet/policer/input')
    input_policer = raw_input_policer if raw_input_policer else "None"
    raw_output_policer = unit.findtext('family/inet/policer/output')
    output_policer = raw_output_policer if raw_output_policer else "None"

	#output_line ga di show semua, tinggal ditambahin aja kalo mau
    output_lines.append(
        f"Interface: {interface_name} | Unit: {unit_name} | Desc: {description} | VLAN: {vlan_id} "
    )

dev.close()


for line in output_lines:
    print(line)