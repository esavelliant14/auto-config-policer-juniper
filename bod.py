#!/usr/bin/env python3
import sys
from jnpr.junos import Device
from jnpr.junos.utils.config import Config
import mysql.connector

# ambil input dari user
device_ip = sys.argv[1]
username = "juniper"
password = "juniper123"
iface_name = sys.argv[2]
unit_name = sys.argv[3]
policer_input_value = sys.argv[4]
policer_output_value = sys.argv[5]
hostname = sys.argv[6]
description = sys.argv[7]
old_input_policer = sys.argv[8]
old_output_policer = sys.argv[9]
datetime = sys.argv[10]

# buka koneksi ke device
with Device(host=device_ip, user=username, passwd=password) as dev:
    with Config(dev, mode='exclusive') as cu:
        # Buat konfigurasi dalam format XML
        config_xml = f"""
        <configuration>
          <interfaces>
            <interface>
              <name>{iface_name}</name>
              <unit>
                <name>{unit_name}</name>
                <family>
                  <inet>
                    <policer>
                      <input>{policer_input_value}</input>
                      <output>{policer_output_value}</output>
                    </policer>
                  </inet>
                </family>
              </unit>
            </interface>
          </interfaces>
        </configuration>
        """
        # load configuration
        cu.load(config_xml, format='xml')
        # commit perubahan
        cu.commit()
        print(f"Policer input/output berhasil diset pada {iface_name} unit {unit_name}.")
try:
    conn = mysql.connector.connect(
        host='localhost',
        user='root',
        password='',
        database='db_bwm'
    )
    cursor = conn.cursor()

    sql = """INSERT INTO table_bod 
             (Hostname, Description, Interface, Unit, Old_input_policer, Old_output_policer, Bod_input_policer, Bod_output_policer, datetime)
             VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)"""

    data_insert = (
        hostname,
        description,
        iface_name,
        unit_name,
        old_input_policer,
        old_output_policer,
        policer_input_value,
        policer_output_value,
        datetime,
    )

    cursor.execute(sql, data_insert)

    sql_update = """
    UPDATE table_client
    SET Input_policer=%s,
        Output_policer=%s
    WHERE Hostname=%s AND Interface=%s AND Unit=%s
    """
    data_update = (policer_input_value, policer_output_value, hostname, iface_name, unit_name)
    cursor.execute(sql_update, data_update)

    conn.commit()
    print("Data perubahan policer berhasil disimpan ke database table_bod.")
except Exception as e:
    print(f"Gagal menyimpan ke database: {e}")
finally:
    if cursor:
        cursor.close()
    if conn:
        conn.close()