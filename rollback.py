#!/usr/bin/env python3
import mysql.connector
from jnpr.junos import Device
from jnpr.junos.utils.config import Config
from datetime import datetime

# koneksi DB
conn = mysql.connector.connect(
    host='localhost',
    user='root',
    password='',
    database='db_bwm'
)
cursor = conn.cursor(dictionary=True)

# Ambil semua record table_bod yang waktunya sudah lewat
cursor.execute("""
    SELECT id, Hostname, Description, Interface, Unit,
           Old_input_policer, Old_output_policer,
           Bod_input_policer, Bod_output_policer, datetime
    FROM table_bod
""")

rows = cursor.fetchall()
now = datetime.now()

for row in rows:
    rollback_time = row['datetime']
    if rollback_time <= now:   # waktunya sudah lewat
        hostname = row['Hostname']
        ip = "192.168.147.222"
        iface_name = row['Interface']
        unit_name = row['Unit']
        old_in = row['Old_input_policer']
        old_out = row['Old_output_policer']

        print(f"Rollback {hostname} {iface_name} unit {unit_name} ke policer lama")

        # koneksi device, restore policer lama
        try:
            with Device(host=ip, user='juniper', passwd='juniper123') as dev:
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
                                  <input>{old_in}</input>
                                  <output>{old_out}</output>
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
        except Exception as e:
            print(f"Gagal rollback ke device {hostname}: {e}")
            continue

        # update table_client agar Input/Output_policer kembali ke lama
        cursor_update = conn.cursor()
        sql_update = """
        UPDATE table_client
        SET Input_policer=%s,
            Output_policer=%s
        WHERE Hostname=%s AND Interface=%s AND Unit=%s
        """
        cursor_update.execute(sql_update, (old_in, old_out, hostname, iface_name, unit_name))
        conn.commit()
        cursor_update.close()

        # hapus atau tandai record table_bod supaya tidak diulang
        cursor_delete = conn.cursor()
        cursor_delete.execute("DELETE FROM table_bod WHERE id=%s", (row['id'],))
        conn.commit()
        cursor_delete.close()

cursor.close()
conn.close()
print("Rollback selesai.")
