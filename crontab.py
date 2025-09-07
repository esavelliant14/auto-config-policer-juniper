#!/usr/bin/env python3
import mysql.connector
from jnpr.junos import Device
from jnpr.junos.utils.config import Config
from datetime import datetime

# koneksi ke database
conn = mysql.connector.connect(
    host='localhost',
    user='root',
    password='',
    database='db_bwm'
)
cursor = conn.cursor(dictionary=True)

# ambil semua entry yang sudah waktunya rollback
cursor.execute("""
    SELECT * FROM table_bod
    WHERE datetime_change <= NOW() AND status='active'
""")

rows = cursor.fetchall()

for row in rows:
    device_ip = row['device_ip']
    iface_name = row['iface_name']
    unit_name = row['unit_name']
    old_input = row['old_input_policer']
    old_output = row['old_output_policer']

    with Device(host=device_ip, user='juniper', passwd='juniper123') as dev:
        with Config(dev, mode='exclusive') as cu:
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
                          <input>{old_input}</input>
                          <output>{old_output}</output>
                        </policer>
                      </inet>
                    </family>
                  </unit>
                </interface>
              </interfaces>
            </configuration>
            """
            cu.load(config_xml, format='xml')
            cu.commit()
            print(f"Rollback policer di {iface_name} unit {unit_name} selesai.")

    # update status di database
    cursor.execute("UPDATE table_bod SET status='rolled_back' WHERE id=%s", (row['id'],))
    conn.commit()

cursor.close()
conn.close()
